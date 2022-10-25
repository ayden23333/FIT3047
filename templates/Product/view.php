<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->Product_ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product'), ['action' => 'delete', $product->Product_ID], ['confirm' => __('Are you sure you want to delete # {0}?', $product->Product_ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Product'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="product view content">
            <h3><?= h($product->Product_ID) ?></h3>
            <table>
                <tr>
                    <th><?= __('Product Name') ?></th>
                    <td><?= h($product->Product_Name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Image') ?></th>
                    <td><?= h($product->Product_Image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product info') ?></th>
                    <td><?= h($product->Product_info) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product ID') ?></th>
                    <td><?= $this->Number->format($product->Product_ID) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Price') ?></th>
                    <td><?= $this->Number->format($product->Product_Price) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
