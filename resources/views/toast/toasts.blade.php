<div id="oiion-toast-container"></div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    @if(Session::has('success'))
      showOiionToast('{{ Session::get("success") }}', 'success');
    @endif

    @if(Session::has('error'))
      showOiionToast('{{ Session::get("error") }}', 'error');
    @endif

    @if(Session::has('warning'))
      showOiionToast('{{ Session::get("warning") }}', 'warning');
    @endif

    @if(Session::has('info'))
      showOiionToast('{{ Session::get("info") }}', 'info');
    @endif
  });
</script>