<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="mt-4">
    <ul class="join">
        <!-- First Page -->
        <li>
            <a class="btn join-item <?= $pager->hasPreviousPage() ? '' : 'btn-disabled' ?>" href="<?= $pager->getFirst() ?>" aria-label="First">
                «
            </a>
        </li>

        <!-- Previous Page -->
        <li>
            <a class="btn join-item <?= $pager->hasPreviousPage() ? '' : 'btn-disabled' ?>" href="<?= $pager->getPreviousPage() ?>" aria-label="Previous">
                ‹
            </a>
        </li>

        <!-- Page Links -->
        <?php foreach ($pager->links() as $link): ?>
            <li>
                <a class="btn join-item <?= $link['active'] ? 'btn-primary' : '' ?>" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <!-- Next Page -->
        <li>
            <a class="btn join-item <?= $pager->hasNextPage() ? '' : 'btn-disabled' ?>" href="<?= $pager->getNextPage() ?>" aria-label="Next">
                ›
            </a>
        </li>

        <!-- Last Page -->
        <li>
            <a class="btn join-item <?= $pager->hasNextPage() ? '' : 'btn-disabled' ?>" href="<?= $pager->getLast() ?>" aria-label="Last">
                »
            </a>
        </li>
    </ul>
</nav>