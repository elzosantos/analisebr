<div class="flash flash-error">
    <input type="hidden" id="mensagem" value="<?php echo h($message); ?>">
    <script type="text/javascript">
        jQuery(document).ready(function() {
            alertify.error($('#mensagem').val());
        });
    </script>
</div>

