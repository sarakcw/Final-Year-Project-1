<?= $this->Form->create(null, ['url' => '/cart-items/add', 'id' => 'add-to-cart-form-search-' . h($product_id)]) ?>
<?= $this->Form->control('product_id', ['type' => 'hidden', 'value' => h($product_id)]) ?>
<?= $this->Form->control('product_quantity', ['type' => 'hidden', 'value' => 1]) ?>
<?= $this->Form->button('Add to Cart', ['type' => 'submit', 'class' => 'quick-view']) ?>
<?= $this->Form->end() ?>
