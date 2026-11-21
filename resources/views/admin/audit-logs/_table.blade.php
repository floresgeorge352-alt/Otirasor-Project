
<style>
/* AUDIT TABLE */
.audit-table-wrap{width:100%;overflow-x:auto}
.audit-table{width:100%;border-collapse:collapse;min-width:850px}
.audit-table th{padding:13px 12px;text-align:left;font-size:13px;color:#023e8a;background:#f5f8fc;border-bottom:2px solid #e1e9f0}
.audit-table td{padding:13px 12px;font-size:14px;color:#444;border-bottom:1px solid #edf1f5;vertical-align:middle}
.audit-table tbody tr:hover{background:#f8fbff}
.audit-table .admin-name{font-weight:700;color:#263746}
.audit-badge{display:inline-block;padding:5px 9px;border-radius:5px;font-size:11px;font-weight:700;white-space:nowrap}
.btn-view-details{background:#eaf3ff;color:#023e8a;border:1px solid #c8dcf5;padding:7px 11px;border-radius:7px;font-size:12px;font-weight:700;cursor:pointer;white-space:nowrap}
.btn-view-details:hover{background:#023e8a;color:white}

/* Pagination */
.audit-pagination{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-top:20px;padding-top:16px;border-top:1px solid #edf1f5}
.audit-pagination-info{font-size:13px;color:#718096}
.audit-pagination-links{display:flex;align-items:center;gap:6px}
.audit-pagination a,.audit-pagination span.page-number{display:inline-flex;align-items:center;justify-content:center;min-width:34px;height:34px;padding:0 10px;border:1px solid #dce5ef;border-radius:7px;background:white;color:#023e8a;font-size:13px;font-weight:600;text-decoration:none}
.audit-pagination a:hover{background:#eaf3ff;border-color:#023e8a}
.audit-pagination .active-page{background:#023e8a!important;color:white!important;border-color:#023e8a!important}
.audit-pagination .disabled-page{color:#aab4c0!important;background:#f5f7fa!important;border-color:#e5eaf0!important;cursor:not-allowed}

/* Details Modal */
.audit-modal{display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.60);padding:20px;align-items:center;justify-content:center}
.audit-modal.show{display:flex}
.audit-modal-content{background:white;width:100%;max-width:650px;max-height:85vh;overflow-y:auto;border-radius:15px;box-shadow:0 15px 45px rgba(0,0,0,.2)}
.audit-modal-header{display:flex;justify-content:space-between;align-items:center;padding:20px 23px;border-bottom:1px solid #e8edf3;position:sticky;top:0;background:white;z-index:2}
.audit-modal-header h3{color:#023e8a;font-size:18px}
.audit-modal-close{border:none;background:#f1f5f9;color:#475569;width:32px;height:32px;border-radius:7px;font-size:20px;cursor:pointer}
.audit-modal-body{padding:22px}
.audit-detail-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-bottom:20px}
.audit-detail-item{background:#f8fafc;border:1px solid #e8edf3;padding:12px;border-radius:9px;min-width:0}
.audit-detail-label{color:#718096;font-size:11px;font-weight:700;text-transform:uppercase;margin-bottom:6px}
.audit-detail-value{color:#263746;font-size:13px;font-weight:600;overflow-wrap:anywhere}
.audit-value-section{margin-top:18px}
.audit-value-section h4{font-size:13px;margin-bottom:9px}
.audit-value-section.old h4{color:#b45309}
.audit-value-section.new h4{color:#047857}
.audit-json{background:#f8fafc;border:1px solid #e2e8f0;border-radius:9px;padding:14px;white-space:pre-wrap;overflow-wrap:anywhere;font-family:Consolas,monospace;font-size:12px;line-height:1.6;color:#334155;max-height:220px;overflow-y:auto}
.audit-no-data{color:#94a3b8;font-size:13px;font-style:italic}

@media(max-width:600px){
.audit-pagination{align-items:flex-start;flex-direction:column}
.audit-pagination-links{flex-wrap:wrap}
.audit-detail-grid{grid-template-columns:1fr}
.audit-modal{padding:10px}
}

/* PRINT */
@media print{
.btn-view-details,.audit-modal{display:none!important}
}
</style>

<div class="audit-table-wrap">
<table class="audit-table">
<thead>
<tr>
<th>Date &amp; Time</th>
<th>Admin</th>
<th>Action</th>
<th>Target ID</th>
<th>IP Address</th>
<th>Details</th>
</tr>
</thead>
<tbody>
@forelse($logs as $log)
<tr>
<td style="white-space:nowrap">{{ $log->created_at->format('M d, Y h:i A') }}</td>
<td class="admin-name">{{ $log->user?$log->user->name:'System/Unknown' }}</td>
<td>
@php
$action=strtolower($log->action);
$badgeStyle='background:#dbeafe;color:#1e40af;';
if(str_contains($action,'approve')||str_contains($action,'verify')){$badgeStyle='background:#d1fae5;color:#065f46;';}
elseif(str_contains($action,'reject')||str_contains($action,'cancel')||str_contains($action,'failed')){$badgeStyle='background:#fee2e2;color:#991b1b;';}
@endphp
<span class="audit-badge" style="{{ $badgeStyle }}">{{ strtoupper(str_replace('_',' ',$log->action)) }}</span>
</td>
<td>{{ $log->model_type?class_basename($log->model_type):'N/A' }} #{{ $log->model_id??'N/A' }}</td>
<td>{{ $log->ip_address??'N/A' }}</td>
<td>
<button type="button" class="btn-view-details" onclick="openAuditDetails(this)"
data-admin="{{ $log->user?$log->user->name:'System/Unknown' }}"
data-action="{{ strtoupper(str_replace('_',' ',$log->action)) }}"
data-date="{{ $log->created_at->format('M d, Y h:i A') }}"
data-target="{{ $log->model_type?class_basename($log->model_type):'N/A' }} #{{ $log->model_id??'N/A' }}"
data-ip="{{ $log->ip_address??'N/A' }}"
data-old="{{ json_encode($log->old_values??[]) }}"
data-new="{{ json_encode($log->new_values??[]) }}">View Details</button>
</td>
</tr>
@empty
<tr><td colspan="6" style="text-align:center;padding:25px;color:#718096">No audit logs found.</td></tr>
@endforelse
</tbody>
</table>
</div>

@if($logs->hasPages())
<div class="audit-pagination">
<div class="audit-pagination-info">Showing {{ $logs->firstItem()??0 }} to {{ $logs->lastItem()??0 }} of {{ $logs->total() }} results</div>
<div class="audit-pagination-links">
@if($logs->onFirstPage())
<span class="disabled-page">‹ Previous</span>
@else
<a href="{{ $logs->previousPageUrl() }}">‹ Previous</a>
@endif
@php
$startPage=max(1,$logs->currentPage()-2);
$endPage=min($logs->lastPage(),$logs->currentPage()+2);
@endphp
@for($page=$startPage;$page<=$endPage;$page++)
@if($page==$logs->currentPage())
<span class="page-number active-page">{{ $page }}</span>
@else
<a href="{{ $logs->appends(request()->query())->url($page) }}">{{ $page }}</a>
@endif
@endfor
@if($logs->hasMorePages())
<a href="{{ $logs->nextPageUrl() }}">Next ›</a>
@else
<span class="disabled-page">Next ›</span>
@endif
</div>
</div>
@endif

<!-- Activity Details Modal -->
<div class="audit-modal" id="auditDetailsModal" onclick="closeAuditDetailsOutside(event)">
<div class="audit-modal-content" role="dialog" aria-modal="true" aria-labelledby="auditModalTitle">
<div class="audit-modal-header">
<h3 id="auditModalTitle">Activity Details</h3>
<button type="button" class="audit-modal-close" onclick="closeAuditDetails()" aria-label="Close">&times;</button>
</div>
<div class="audit-modal-body">
<div class="audit-detail-grid">
<div class="audit-detail-item"><div class="audit-detail-label">Admin</div><div class="audit-detail-value" id="detailAdmin"></div></div>
<div class="audit-detail-item"><div class="audit-detail-label">Action</div><div class="audit-detail-value" id="detailAction"></div></div>
<div class="audit-detail-item"><div class="audit-detail-label">Date &amp; Time</div><div class="audit-detail-value" id="detailDate"></div></div>
<div class="audit-detail-item"><div class="audit-detail-label">Target</div><div class="audit-detail-value" id="detailTarget"></div></div>
<div class="audit-detail-item"><div class="audit-detail-label">IP Address</div><div class="audit-detail-value" id="detailIP"></div></div>
</div>
<div class="audit-value-section old">
<h4>OLD VALUES</h4>
<pre class="audit-json" id="detailOld"></pre>
</div>
<div class="audit-value-section new">
<h4>NEW VALUES</h4>
<pre class="audit-json" id="detailNew"></pre>
</div>
</div>
</div>
</div>

<script>
function openAuditDetails(button){
const modal=document.getElementById('auditDetailsModal');
document.getElementById('detailAdmin').textContent=button.dataset.admin||'N/A';
document.getElementById('detailAction').textContent=button.dataset.action||'N/A';
document.getElementById('detailDate').textContent=button.dataset.date||'N/A';
document.getElementById('detailTarget').textContent=button.dataset.target||'N/A';
document.getElementById('detailIP').textContent=button.dataset.ip||'N/A';

function formatValues(value){
try{
const parsed=JSON.parse(value);
if(!parsed||Object.keys(parsed).length===0)return 'No recorded values.';
return JSON.stringify(parsed,null,2);
}catch(error){return 'Unable to display activity values.';}
}

document.getElementById('detailOld').textContent=formatValues(button.dataset.old);
document.getElementById('detailNew').textContent=formatValues(button.dataset.new);
modal.classList.add('show');
document.body.style.overflow='hidden';
}

function closeAuditDetails(){
const modal=document.getElementById('auditDetailsModal');
if(modal){modal.classList.remove('show');document.body.style.overflow='';}
}

function closeAuditDetailsOutside(event){
if(event.target.id==='auditDetailsModal')closeAuditDetails();
}

// Close modal using Escape key
document.addEventListener('keydown',function(event){
if(event.key==='Escape')closeAuditDetails();
});
</script>
