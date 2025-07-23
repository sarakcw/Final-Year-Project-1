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
            <?= $this->Html->link(__('Edit Contact Enquiry'), ['action' => 'edit', $contactEnquiry->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Contact Enquiry'), ['action' => 'delete', $contactEnquiry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contactEnquiry->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Contact Enquiries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Contact Enquiry'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="contactEnquiries view content">
            <h3><?= h($contactEnquiry->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($contactEnquiry->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($contactEnquiry->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($contactEnquiry->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Number') ?></th>
                    <td><?= h($contactEnquiry->phone_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reply Status') ?></th>
                    <td><?= h($contactEnquiry->replied) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($contactEnquiry->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Sent') ?></th>
                    <td><?= h($contactEnquiry->date_sent) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($contactEnquiry->message)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>