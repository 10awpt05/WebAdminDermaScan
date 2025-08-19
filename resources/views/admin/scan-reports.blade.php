@extends('mainapp')

@section('title', 'Scan Reports')

@section('content')
<div class="container">
    <h1>Scan Reports</h1>
    <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Reported By</th>
                <th>View Report</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @forelse($scanReports as $reportId => $report)
                <tr>
                    <td>{{ $report['userName'] ?? 'Unknown' }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                            onclick='showReportModal(
                                @json($report["imageBase64"] ?? ""),
                                @json($report["message"] ?? ""),
                                @json(isset($report["timestamp"]) ? date("Y-m-d H:i:s", $report["timestamp"]/1000) : "")
                            )'>
                            View
                        </button>
                    </td>
                    <td>{{ isset($report['timestamp']) ? date('Y-m-d H:i:s', $report['timestamp']/1000) : '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No scan reports found.</td>
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
        <h5 class="modal-title">Scan Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="reportImage" src="" class="img-fluid mb-3" style="max-height: 400px;">
        <p><strong>Message:</strong> <span id="reportMessage"></span></p>
        <p><strong>Timestamp:</strong> <span id="reportTimestamp"></span></p>
      </div>
    </div>
  </div>
</div>

<script>
function showReportModal(imageBase64, message, timestamp) {
    document.getElementById('reportImage').src = imageBase64 
        ? 'data:image/jpeg;base64,' + imageBase64 
        : '';
    document.getElementById('reportMessage').textContent = message || 'No message';
    document.getElementById('reportTimestamp').textContent = timestamp || 'N/A';

    new bootstrap.Modal(document.getElementById('reportModal')).show();
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
