<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

/**
 * ContactEnquiries Controller
 *
 * @property \App\Model\Table\ContactEnquiriesTable $ContactEnquiries
 */
class ContactEnquiriesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // Allow unauthenticated access to add action
        $this->Authentication->addUnauthenticatedActions(['add']);
    }

    /**
     * Before filter method
     *
     * @param \Cake\Event\EventInterface $event Event object
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        if ($this->request->getParam('action') === 'add') {
            return;
        }

        $user = $this->Authentication->getIdentity();

        if ($user && $user->user_type === 'Admin') {
            $this->viewBuilder()->setLayout('admin');
        }

        if ($user->user_type !== 'Admin') {
            $this->response = $this->response->withStringBody(
                '<script>alert("You do not have permission to access this page."); window.location.href = "/";</script>'
            );
            return $this->response;
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ContactEnquiries->find();
        $contactEnquiries = $this->paginate($query);

        $this->set(compact('contactEnquiries'));
    }

    /**
     * View method
     *
     * @param string|null $id Contact Enquiry id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $contactEnquiry = $this->ContactEnquiries->get($id, contain: []);
        $this->set(compact('contactEnquiry'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contactEnquiry = $this->ContactEnquiries->newEmptyEntity();
        if ($this->request->is('post')) {

            $data = $this->request->getData();
            //sanitize inputs from HTML injection
            $data['first_name'] = strip_tags($data['first_name']); // Removing any HTML tags
            $data['last_name'] = strip_tags($data['last_name']);
            $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL); // Sanitizing email
            $data['phone_number'] = strip_tags($data['phone_number']);
            $data['message'] = strip_tags($data['message']);

            $contactEnquiry = $this->ContactEnquiries->patchEntity($contactEnquiry, $this->request->getData());

            // Automatically set the date
            $contactEnquiry->date_sent = date('Y-m-d H:i:s');

            if ($this->Recaptcha->verify()) { //verify reCaptcha
                if ($this->ContactEnquiries->save($contactEnquiry)) { //save the contact form
                    $this->Flash->success(__('Your enquiry has been submitted successfully. We will get back to you as soon as possible!'),
                        ['key'=> 'contactFeedback']);

//                        return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']); //redirect to homepage
                    return $this->redirect(['controller' => 'ContactEnquiries', 'action' => 'add']); //refresh page to show pop up msg
                } else {
                    $this->Flash->error(__('The contact enquiry could not be saved. Please, try again.'), ['key'=> 'contactFeedback']);
                }
            }else {
                // No reCAPTCHA response was provided, handle this case
                $this->Flash->error(__('Please complete the reCAPTCHA.'), ['key'=> 'contactFeedback']);
            }
        }

        //set the variable to be sent into the view for use in the reCAPTCHA field
        $this->set(compact('contactEnquiry'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contact Enquiry id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $contactEnquiry = $this->ContactEnquiries->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contactEnquiry = $this->ContactEnquiries->patchEntity($contactEnquiry, $this->request->getData());
            if ($this->ContactEnquiries->save($contactEnquiry)) {
                $this->Flash->success(__('The contact enquiry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact enquiry could not be saved. Please, try again.'));
        }
        $this->set(compact('contactEnquiry'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact Enquiry id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contactEnquiry = $this->ContactEnquiries->get($id);
        if ($this->ContactEnquiries->delete($contactEnquiry)) {
            $this->Flash->success(__('The contact enquiry has been deleted.'));
        } else {
            $this->Flash->error(__('The contact enquiry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
