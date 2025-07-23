<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ContactEnquiry> $contactEnquiries
 */
echo $this->Html->css(['cake', 'fonts', 'milligram.min', 'normalize.min']);

?>
<div class="contactEnquiries index content" style="padding-top: 60px;">
    <?= $this->Html->link(__('New Contact Enquiry'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Contact Enquiries') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('phone_number') ?></th>
                    <th><?= $this->Paginator->sort('replied') ?></th>
                    <th><?= $this->Paginator->sort('date_sent') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactEnquiries as $contactEnquiry): ?>
                <tr>
                    <td><?= $this->Number->format($contactEnquiry->id) ?></td>
                    <td><?= h($contactEnquiry->first_name) ?></td>
                    <td><?= h($contactEnquiry->last_name) ?></td>
                    <td><?= h($contactEnquiry->email) ?></td>
                    <td><?= h($contactEnquiry->phone_number) ?></td>
                    <td><?= h($contactEnquiry->replied) ?></td>
                    <td><?= h($contactEnquiry->date_sent) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contactEnquiry->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contactEnquiry->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $contactEnquiry->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $contactEnquiry->id),
                            ]
                        ) ?>
                        <?= $this->Html->link(__('Email'), 'mailto:' . $contactEnquiry->email) ?>
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
