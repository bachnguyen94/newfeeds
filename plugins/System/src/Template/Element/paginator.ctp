<nav class="text-center">
    <ul class="pagination">
        <li><?= $this->Paginator->prev('« Previous') ?></li>
        <li><?= $this->Paginator->numbers() ?></li>
        <li><?= $this->Paginator->next('Next »') ?></li>
    </ul>
</nav>