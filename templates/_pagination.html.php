<?php if ($totalPages > 1 && $baseUrl): ?>
    <nav class="pagination flex-row gap">
        
        <!-- Previous Link -->
        <a 
            href="<?= $baseUrl . ($currentPage - 1) ?>"
            class="<?= $currentPage > 1 ? 'enabled' : 'disabled' ?>"
            <?= $currentPage <= 1 ? 'tabindex="-1"' : '' ?>
        >
            Previous
        </a>

        <!-- Page Number Links -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a 
                href="<?= $baseUrl . $i ?>" 
                class="<?= $i == $currentPage ? 'active' : '' ?> page-number"
            >
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <!-- Next Link -->
        <a 
            href="<?= $baseUrl . ($currentPage + 1) ?>"
            class="<?= $currentPage < $totalPages ? 'enabled' : 'disabled' ?>"
            <?= $currentPage >= $totalPages ? 'tabindex="-1"' : '' ?>
        >
            Next
        </a>

    </nav>
<?php endif; ?>