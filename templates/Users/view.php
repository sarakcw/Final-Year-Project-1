<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="users view content">
            <h3><?= h($user->email) ?></h3>
            <table>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($user->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($user->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($user->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Type') ?></th>
                    <td><?= h($user->user_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Loyalty Points') ?></th>
                    <td><?= $user->loyalty_points === null ? __('Not set') : $this->Number->format($user->loyalty_points) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($user->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nonce') ?></th>
                    <td><?= h($user->nonce) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Birthday') ?></th>
                    <td>
                        <?php 
                        if ($user->birthday) {
                            $date = new \DateTime($user->birthday);
                            $months = [
                                '1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April',
                                '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August',
                                '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                            ];
                            echo $date->format('d') . ' ' . $months[$date->format('n')];
                        } else {
                            echo __('Not set');
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Nonce Expiry') ?></th>
                    <td><?= h($user->nonce_expiry) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>