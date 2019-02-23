<div class="flash flash-success">
    <input type="hidden" id="mensagem" value="<?php echo h($message); ?>">
    <script type="text/javascript">
        jQuery(document).ready(function() {
            alertify.success($('#mensagem').val());
        });
    </script>
</div>

