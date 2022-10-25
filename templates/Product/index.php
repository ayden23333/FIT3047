<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $product
 */
?>
<div class="product index content">
    <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <button style="margin-left: 770px">
        <?=  $this->Html->link("Back",['controller'=>'Staff','action'=>'adminpage']) ?>
    </button>
    <h3><?= __('Product') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Product_ID') ?></th>
                    <th><?= $this->Paginator->sort('Product_Name') ?></th>
                    <th><?= $this->Paginator->sort('Product_Price') ?></th>
                    <th><?= $this->Paginator->sort('Product_Image') ?></th>
                    <th><?= $this->Paginator->sort('Product_info') ?></th>
                    <th><?= $this->Paginator->sort('Product_Count') ?></th>

                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product as $product): ?>
                <tr>
                    <td><?= $this->Number->format($product->Product_ID) ?></td>
                    <td><?= h($product->Product_Name) ?></td>
                    <td><?= $this->Number->format($product->Product_Price) ?></td>
                    <td><?= h($product->Product_Image) ?></td>
                    <td><?= h($product->Product_info) ?></td>
                    <td><?= $this->Number->format($product->Project_Total) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $product->Product_ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->Product_ID]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->Product_ID], ['confirm' => __('Are you sure you want to delete # {0}?', $product->Product_ID)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
