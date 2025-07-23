<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="row">
    <?= $this->Html->tag('button', '<i class="bi bi-arrow-left"></i>  Back',
        ['type' => 'button',
            'onclick' => 'if(confirm("Are you sure you want to go back? Your changes will not be saved.")){window.history.back();}',
            'class' => 'btn back-btn text-start w-auto']) ?>
    <div class="alert alert-dismissible fade show" role="alert">
        <?= $this->Flash->render('productAddFeedback');?>
    </div>
    <div class="row pb-5 mb-5 justify-content-center">
        <div class="col-md-8">
            <div class="admin-form mt-3 mb-2 mx-auto">
                <div class="admin-card-header text-black text-center pt-4 mb-3">
                    <?= __('Edit Product Details') ?>
                </div>
                <div class=card-body>
                    <?= $this->Form->create($product,['type' => 'file']) ?>

                    <div class="mb-3"><?= $this->Form->control('name', ['label' => 'Name of Wine *',
                            'class' => 'form-control',
                            'placeholder'=>'Enter name of wine',
                            'required' => true]);?></div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('stock_quantity', ['label' => 'Stock Quantity', 'class' => 'form-control', 'placeholder'=>'Enter stock quantity','type' =>'number']);?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('price', ['label' => 'Price *', 'class' => 'form-control', 'placeholder'=>'Enter price per bottle', 'type'=>'number', 'required' => true]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?=  $this->Form->control('vintage', ['label' => 'Vintage Year',
                                'placeholder'=>'Enter vintage year of wine',
                                'options' => array_combine(range(date('Y'), 1900), range(date('Y'), 1900)),
                                'class' => 'select form-control']);?></div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('alcohol_content', ['label' => 'Alcohol Content', 'placeholder'=>'Enter alcohol content of the wine (e.g. 15.40)', 'type' => 'number', 'class' => 'form-control']);?>
                        </div>
                    </div>

                    <div class="mb-3"><?= $this->Form->control('region',
                            ['label' => 'Region *', 'placeholder'=>'Enter region of wine', 'class' => 'form-control',
                                'required' => true,
                                'pattern' => '[A-Za-z\-]+',
                                'title' => 'Only alphabetic characters and hyphens are allowed']);?></div>

                    <div class="mb-3"><?= $this->Form->control('style', ['label' => 'Style *',
                            'class' => 'form-control style',
                            'required' => true,
                            'options' =>[
                                'Red'=> 'Red',
                                'White' => 'White',
                                'Rose' => 'Rose',
                                'Sparkling' => 'Sparkling',
                                'Fortified' => 'Fortified',
                                'Dessert' => 'Dessert'
                            ],
                            'empty' => 'Select a wine style'
                        ]);?>
                    </div>
                    <div class="mb-3">
                        <div class="mb-3"><?= $this->Form->control('image', ['type' => 'file', 'label' => 'Upload Image', 'required' => false]) ?></div>
                        <small class="form-text text-muted">Allowed formats: JPG, JPEG, PNG, GIF</small>
                    </div>
                    <div class="mb-3 pb-3"><?= $this->Form->control('status', ['label' => 'Status *',
                            'class' => 'form-control status',
                            'required' => true,
                            'options' =>[
                                'Listed' => 'Listed',
                                'Unlisted' => 'Unlisted'
                            ],
                            'empty' => 'Select a status'
                        ]);?>
                    </div>
                    <div class="text-end">
                        <!-- cancel button-->
                        <?= $this->Html->tag('button', 'Cancel',
                            ['type' => 'button',
                                'onclick' => 'if(confirm("Are you sure you want to cancel? Your changes will not be saved.")){window.history.back();}',
                                'class' => 'btn admin-btn-cancel']) ?>

                        <?= $this->Form->button(__('Update Details'), ['class' => 'btn  admin-btn-submit']) ?>
                    </div>
                    <?= $this->Form->end() ?>

                </div>
            </div>
        </div>
    </div>
</div>
