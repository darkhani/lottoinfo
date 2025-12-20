    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <p>&copy; <?php echo date('Y'); ?> 로또 정보 포털. All rights reserved.</p>
                <p class="footer-note">만든이: 한인택 [테기네닷컴]</p>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
    <?php if (isset($includeLottoDraw) && $includeLottoDraw): ?>
    <script src="assets/js/lotto-draw.js"></script>
    <?php endif; ?>
    <?php if (isset($includeViewToggle) && $includeViewToggle): ?>
    <script src="assets/js/view-toggle.js"></script>
    <?php endif; ?>
    <?php if (isset($includeFilters) && $includeFilters): ?>
    <script src="assets/js/filters.js"></script>
    <?php endif; ?>
</body>
</html>

