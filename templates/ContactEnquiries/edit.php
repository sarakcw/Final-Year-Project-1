<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactEnquiry $contactEnquiry
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contactEnquiry->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contactEnquiry->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Contact Enquiries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="contactEnquiries form content">
            <?= $this->Form->create($contactEnquiry) ?>
            <fieldset>
                <legend><?= __('Edit Contact Enquiry') ?></legend>
                <?php
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('phone_number');
                    echo $this->Form->control('message');
                    echo $this->Form->control('date_sent', ['empty' => true]);
                    echo $this->Form->control('replied', [
                        'type' => 'select',
                        'options' => ['not replied' => 'Not Replied', 'replied' => 'Replied'],
                        'class' => 'form-control'
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
