<?php
namespace Revisions\Controller;

use Revisions\Controller\AppController;

/**
 * Revisions Controller
 *
 * @property \Revisions\Model\Table\RevisionsTable $Revisions
 */
class RevisionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('revisions', $this->paginate($this->Revisions));
        $this->set('_serialize', ['revisions']);
    }

    /**
     * View method
     *
     * @param string|null $id Revision id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $revision = $this->Revisions->get($id, [
            'contain' => ['Phinxlog']
        ]);
        $this->set('revision', $revision);
        $this->set('_serialize', ['revision']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $revision = $this->Revisions->newEntity();
        if ($this->request->is('post')) {
            $revision = $this->Revisions->patchEntity($revision, $this->request->data);
            if ($this->Revisions->save($revision)) {
                $this->Flash->success(__('The revision has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The revision could not be saved. Please, try again.'));
            }
        }
        $phinxlog = $this->Revisions->Phinxlog->find('list', ['limit' => 200]);
        $this->set(compact('revision', 'phinxlog'));
        $this->set('_serialize', ['revision']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Revision id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $revision = $this->Revisions->get($id, [
            'contain' => ['Phinxlog']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $revision = $this->Revisions->patchEntity($revision, $this->request->data);
            if ($this->Revisions->save($revision)) {
                $this->Flash->success(__('The revision has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The revision could not be saved. Please, try again.'));
            }
        }
        $phinxlog = $this->Revisions->Phinxlog->find('list', ['limit' => 200]);
        $this->set(compact('revision', 'phinxlog'));
        $this->set('_serialize', ['revision']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Revision id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $revision = $this->Revisions->get($id);
        if ($this->Revisions->delete($revision)) {
            $this->Flash->success(__('The revision has been deleted.'));
        } else {
            $this->Flash->error(__('The revision could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
