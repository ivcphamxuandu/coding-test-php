<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\View\JsonView;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // $this->loadComponent('Authentication.Authentication');
    }

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $articles = $this->paginate($this->Articles);
        $this->set(compact('articles'));
        $this->response = $this->response->withType('json');
        // Set serialization options for pagination results
        $this->set([
            'articles' => $articles,
            '_serialize' => 'articles'
        ]);
        // Disable view rendering for API endpoints
        $this->viewBuilder()->disableAutoLayout();
        $this->viewBuilder()->setOption('serialize', 'articles');
        echo json_encode(compact('articles'));
        return $this->response;
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('article'));
        // Disable view rendering for API endpoints
        $this->viewBuilder()->disableAutoLayout();
        $this->viewBuilder()->setOption('serialize', 'articles');
        echo json_encode(compact('article'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }
        $users = $this->Articles->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('article', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }
        $users = $this->Articles->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('article', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function like($id = null)
    {
        $article = $this->Articles->get($id);
        $this->request->allowMethod(['post']);

        // Check if user has already liked the article
        $userId = $this->Authentication->getIdentity()->id;
        foreach ($article->user_article_likes as $like) {
            if ($like->user_id === $userId) {
                $this->Flash->error('You have already liked this article.');
                return $this->redirect(['action' => 'view', $id]);
            }
        }

        // Update like count and save like
        $article->like_count++;
        $articleLike = $this->Articles->UserArticleLikes->newEntity(['user_id' => $userId]);
        $article->user_article_likes[] = $articleLike;
        if ($this->Articles->save($article, ['associated' => ['UserArticleLikes']])) {
            $this->Flash->success('Article liked successfully.');
        } else {
            $this->Flash->error('Failed to like the article.');
        }

        return $this->redirect(['action' => 'view', $id]);
    }

}
