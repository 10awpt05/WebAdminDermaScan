@extends('mainapp')

@section('title', 'Scan Reports')

@section('content')
<div class="container">
    <h1>Scan Reports</h1>
    <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Reported By</th>
                <th>Condition</th>
                <th>View Report</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @forelse($scanReports as $reportId => $report)
                @php
                    $scanResult = $report['scanResult'] ?? [];
                    $userName = $report['userName'] ?? 'Unknown';
                    $condition = $scanResult['condition'] ?? 'No condition';
                    $imageBase64 = $scanResult['imageBase64'] ?? '';
                    $remedy = $scanResult['remedy'] ?? '';
                    $timestamp = $scanResult['timestamp'] ?? '';
                    $message = $report['message'] ?? 'No message provided';
                @endphp

                <tr>
                    <td>{{ $userName }}</td>
                    <td>{{ $condition }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                            onclick='showReportModal(
                                @json($imageBase64),
                                @json($condition),
                                @json($remedy),
                                @json($message),
                                @json($timestamp)
                            )'>
                            View
                        </button>
                    </td>
                    <td>{{ $timestamp }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No scan reports found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Scan Report Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="reportImage" src="" class="img-fluid mb-3" style="max-height: 400px;">
        <p><strong>Condition:</strong> <span id="reportCondition"></span></p>
        <p><strong>Remedy:</strong> <span id="reportRemedy"></span></p>
        <p><strong>Message:</strong> <span id="reportMessage"></span></p>
        <p><strong>Timestamp:</strong> <span id="reportTimestamp"></span></p>
      </div>
    </div>
  </div>
</div>

<script>
function showReportModal(imageBase64, condition, remedy, message, timestamp) {
    document.getElementById('reportImage').src = imageBase64 
        ? 'data:image/jpeg;base64,' + imageBase64 
        : '';
    document.getElementById('reportCondition').textContent = condition || 'N/A';
    document.getElementById('reportRemedy').textContent = remedy || 'N/A';
    document.getElementById('reportMessage').textContent = message || 'N/A';
    document.getElementById('reportTimestamp').textContent = timestamp || 'N/A';

    new bootstrap.Modal(document.getElementById('reportModal')).show();
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
