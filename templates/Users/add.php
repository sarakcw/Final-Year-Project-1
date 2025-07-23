<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="container mt-6 mb-5">
    <div class="alert alert-dismissible fade show" role="alert">
        <?= $this->Flash->render();?>
    </div>
    <div class="container contact-banner">
        <h4 class="text-center">ADD USER</h4>
        <p class="text-center">Create a new user account for Divine Vines</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-contact mt-5 mb-2">
                <div class="contact-card-header text-black text-center pt-2">
                    <h4><?= __(' _______ ') ?></h4>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($user) ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('first_name', [
                                'label' => 'First Name *',
                                'class' => 'form-control',
                                'required' => true
                            ]); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('last_name', [
                                'label' => 'Last Name *',
                                'class' => 'form-control',
                                'required' => true
                            ]); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('email', [
                            'label' => 'Email *',
                            'class' => 'form-control',
                            'type' => 'email',
                            'required' => true
                        ]); ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('phone', [
                            'label' => 'Phone Number *',
                            'class' => 'form-control',
                            'type' => 'tel',
                            'required' => true
                        ]); ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('user_type', [
                            'label' => 'User Type *',
                            'class' => 'form-control',
                            'required' => true,
                            'options' => [
                                'Admin' => 'Admin',
                                'staff' => 'Staff Member',
                                'customer' => 'Customer'
                            ]
                        ]); ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('loyalty_points', [
                            'label' => 'Loyalty Points',
                            'class' => 'form-control',
                            'type' => 'number',
                            'min' => 0,
                            'max' => 100
                        ]); ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('birthday', [
                            'label' => 'Birthday',
                            'class' => 'form-control',
                            'type' => 'date'
                        ]); ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('address', [
                            'label' => 'Address',
                            'class' => 'form-control',
                            'type' => 'text'
                        ]); ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('password', [
                                'label' => 'Password *',
                                'class' => 'form-control',
                                'type' => 'password',
                                'required' => true
                            ]); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('password_confirm', [
                                'label' => 'Confirm Password *',
                                'class' => 'form-control',
                                'type' => 'password',
                                'required' => true
                            ]); ?>
                        </div>
                    </div>

                    <div class="text-center">
                        <?= $this->Form->button(__('Create User'), ['class' => 'btn btn-contact w-100']) ?>
                    </div>

                    <div class="mt-3 text-center">
                        <?= $this->Html->link(__('Back to Users List'), ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
