<script>
    function jqueryDispatch(modalName) {
        window.dispatchEvent(new CustomEvent('open-modal', { detail: modalName }));
    }
</script>
