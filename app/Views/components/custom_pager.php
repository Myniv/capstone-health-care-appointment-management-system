<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item <?= $pager->hasPreviousPage() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="<<">
                <span aria-hidden="true">
                    << </span>
            </a>
        </li>
        <li class="page-item <?= $pager->hasPreviousPage() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="<">
                <span aria-hidden="true">
                    < </span>
            </a>
        </li>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <li class="page-item <?= $pager->hasNextPage() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label=">">
                <span aria-hidden="true">></span>
            </a>
        </li>
        <li class="page-item <?= $pager->hasNextPage() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->getLast() ?>" aria-label=">>">
                <span aria-hidden="true">>></span>
            </a>
        </li>
    </ul>
</nav>