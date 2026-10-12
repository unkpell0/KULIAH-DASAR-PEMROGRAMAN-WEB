<?php /** @var string $assetBase */ ?>
</main>
    <footer>
        <p>&copy; 2026 SIFILM-Mini &mdash; Jobsheet 7</p>
    </footer>
    <link rel="stylesheet" href="<?php echo $assetBase; ?>assets/css/style.css">
    <script src="<?php echo $assetBase; ?>assets/js/app.js"></script>   
    <?php if (!empty($extra_scripts)): foreach ($extra_scripts as $src): ?>
    <script src="<?php echo $src; ?>"></script>
    <?php endforeach;
    endif; ?>
</body>
</html>