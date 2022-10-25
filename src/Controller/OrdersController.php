<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Orders Controller
 *
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $User = $this->Auth->user();
        if($User){
            if($User['status']){
                $this->paginate = [
                    'contain' => []
                    //'conditions' => ['User_ID' => $User_ID]
                ];
                $orders = $this->paginate($this->Orders);
            }else{
                $this->paginate = [
                    'contain' => [],
                    'conditions' => ['User_ID' => $User['id']]
                ];
                $orders = $this->paginate($this->Orders);
            }
        }else{
            $this->paginate = [
                'contain' => [],
                'conditions' => ['User_ID' => 0]
            ];
            $orders = $this->paginate($this->Orders);
        }
        // debug($User);
        // exit;
        // if($User_ID){

        // }

        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('order'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($Cart_ID=null)
    {
        $order = $this->Orders->newEmptyEntity();
        if ($this->request->is('post')) {
            $cart = $this->Orders->Carts->get($Cart_ID, [
                'contain' => ['Product','Users'],
            ]);
            $data = array(
                "Product_ID"  => $cart->Product_ID,
                "Cart_ID" => $cart->id,
                "User_ID" => $cart->User_ID,
                "Order_address" => $this->request->getData('Order_address'),
            );

            $order = $this->Orders->patchEntity($order, $data);
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['controller'=>'Cart','action'=>'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }

        if ($this->request->is('get')) {
            $cart = $this->Orders->Carts->get($Cart_ID, [
                'contain' => ['Product','Users'],
            ]);
            $this->set('cart', $cart);
        }
        $this->set(compact('order'));

    }
    public function addall(){
        $User_ID = $this->Auth->user('id');
        if($User_ID){
            $order = $this->Orders->newEmptyEntity();
            if ($this->request->is('post')) {
                $query = $this->Orders->Carts->find("all", [
                    'contain' => ['Product','Users'],
                    'conditions' => ['Carts.User_ID' => $User_ID]
                ]);
                $item = Array();
                $carts = $query->all();
                foreach ($carts as $cart) {
                    $id = $cart->product->Product_ID;
                    $product = $this->Orders->Product->get($id, [
                        'contain' => [],
                    ]);
                    $reduceCount = $cart->product->Project_Total - $cart->count;
                    $product1 = $this->Orders->Product->patchEntity($product,array());
                    $product1->Project_Total = $reduceCount;
                    $this->Orders->Product->save($product1);

                    $order = $this->Orders->newEmptyEntity();
                    $item = array(
                        "Product_ID"  => $cart->Product_ID,
                        "Product_Count" => $cart->count,
                        "User_ID" => $cart->User_ID,
                        "Order_address" => $this->request->getData('Order_address'),
                    );
                    $order = $this->Orders->patchEntity($order, $item);
                    $this->Orders->save($order);

                    $curcart = $this->Orders->Carts->get($cart->id);
                    $this->Orders->Carts->delete($curcart);
                }
                $this->Flash->success(__('The order has been saved.'));
                return $this->redirect(['controller'=>'Product','action'=>'homepage']);
            }
            if ($this->request->is('get')) {
                $query = $this->Orders->Carts->find("all", [
                    'contain' => ['Product','Users'],
                    'conditions' => ['Carts.User_ID' => $User_ID]
                ]);
                $cart = $query->all();
                $this->set('cart', $cart);
            }
            $this->set(compact('order'));
        }else{
            $order = $this->Orders->newEmptyEntity();
            $product = $this->Orders->Product->newEmptyEntity();
            if($this->request->is('get')){
                $query =  $this->getTableLocator()->get('Product'); //$this->paginate($this->Product);
                $product = $query->find()->all();
                $products = array();
                $carts=json_decode($_COOKIE["productInfo"]);
                foreach($product as $proIndex=>$proItem){
                    foreach($carts as $index=>$item){
                        if($item->productId == $proItem['Product_ID']){
                            array_push($products, array(
                                'product'=>$proItem,
                                'Product_ID'=>$proItem['Product_ID'],
                                'count'=>$item->count,
                                'id'=>$index,
                                'User_ID'=>0,
                                'user'=>array()
                            ));
                            // $carts[$index]->Product_ID = $proItem['Product_ID'];
                            // $carts[$index]->Product_Name = $proItem['Product_Name'];
                            // $carts[$index]->Product_Price = $proItem['Product_Price'];
                            // $carts[$index]->Project_Total = $proItem['Project_Total'];
                            // $carts[$index]->Product_Image = $proItem['Product_Image'];
                            // $carts[$index]->Product_info = $proItem['Product_info'];
                        }

                    }
                }
                // debug($products);
                // debug($carts);
                //$products1 = (object)['items'=>$products];
                //debug($products);
                $this->set(array('cart'=>$products));
                $this->set(compact('order'));
            }
            if ($this->request->is('post')) {
                $query = $this->getTableLocator()->get('Product'); //$this->paginate($this->Product);
                $products = $query->find()->all();
                $carts = json_decode($_COOKIE["productInfo"]);

                // 遍历购物车
                foreach ($carts as $cartIndex=>$cartItem) {
                    // 遍历所有商品
                    foreach($products as $proIndex=>$productItem){
                        if($cartItem->productId == $productItem->Product_ID){

                            $reduceCount = $productItem->Project_Total - $cartItem->count;
                            $product1 = $this->Orders->Product->patchEntity($productItem,array());
                            $product1->Project_Total = $reduceCount;

                            $this->Orders->Product->save($product1);
                            $order = $this->Orders->newEmptyEntity();
                            $item = array(
                                "Product_ID"  => $cartItem->productId,
                                "Product_Count" => $cartItem->count,
                                "User_ID" => 0,
                                "Order_address" => $this->request->getData('Order_address'),
                            );
                            $order = $this->Orders->patchEntity($order, $item);
                            setcookie("productInfo", "" , time()-1,'/');
                            $this->Orders->save($order);
                        }
                    }
                }
                return $this->redirect(['controller'=>'Cart','action'=>'index']);
            }


            // exit;
            // if ($this->request->is('get')) {
            //     $query = $this->Orders->Carts->find("all", [
            //         'contain' => ['Product','Users'],
            //         'conditions' => ['Carts.User_ID' => $User_ID]
            //     ]);
            //     $cart = $query->all();
            //     $this->set('cart', $cart);
            // }
        }

    }
    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $this->set(compact('order'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
