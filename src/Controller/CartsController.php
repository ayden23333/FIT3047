<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CartsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $User_ID = $this->Auth->user('id');
        if($User_ID){
            $this->paginate = [
                'contain' => ['Product','Users'],
                'conditions' => ['User_ID' => $User_ID]
            ];
            $carts = $this->paginate($this->Carts);
            $this->set(compact('carts'));
        }else{
            $query =  $this->getTableLocator()->get('Product'); //$this->paginate($this->Product);
            $product = $query->find()->all();
            $products = array();
            if(isset($_COOKIE["productInfo"])){
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
                $this->set(array('carts'=>$products));
            }else{
                $this->paginate = [
                    'contain' => ['Product','Users'],
                    'conditions' => ['User_ID' => 0]
                ];
                $carts = $this->paginate($this->Carts);
                $this->set(compact('carts'));
            }
        }
    }

    /**
     * View method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => [],
        ]);
        $this->set(compact('cart'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $cart = $this->Carts->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $cart = $this->Carts->patchEntity($cart, $this->request->getData());
    //         if ($this->Carts->save($cart)) {
    //             $this->Flash->success(__('The cart has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The cart could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('cart'));
    // }

    // public function addOrder($Carts=null)
    // {
    //     $cart = $this->Carts->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $order = $this->Orders->patchEntity($order, $this->request->getData());
    //         if ($this->Orders->save($order)) {
    //             $this->Flash->success(__('The order has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The order could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('order'));
    // }

    public function add($Product_ID=null)
    {
        $User_ID = $this->Auth->user('id');
        if($User_ID){
            $cart = $this->Carts->newEmptyEntity();
            if ($this->request->is('post')) {
                $query = $this->Carts->find("all", [
                    'contain' => [],
                    'conditions' => ['Product_ID' => $Product_ID]
                ]);
                $carts = $query->all();
                if($carts->isempty()){ //no value
                    $data = array(
                        "Product_ID"  => $Product_ID,
                        "count" => 1,
                        "User_ID" => $this->Auth->user('id')
                    );
                    $cart = $this->Carts->patchEntity($cart, $data);
                    if ($this->Carts->save($cart)) {
                        $this->Flash->success(__('The cart has been saved.'));

                        return $this->redirect(['controller'=>'Product', 'action' => 'cracker']);
                    }
                    $this->Flash->error(__('The cart could not be saved. Please, try again.'));
                }else{ // "have value";
                    foreach ($carts as $cart) {
                        $list = $this->Carts->newEmptyEntity();
                        $count = $cart->count;
                        $count++;
                        $item = array(
                            "id" => $cart->id,
                            "Product_ID"  => $Product_ID,
                            "count" => $count,
                            "User_ID" => $this->Auth->user('id')
                        );
                        $order = $this->Carts->patchEntity($list, $item);
                        $id = $cart->id;
                        $order->id = $id;
                        $this->Carts->save($order);
                    }
                    $this->Flash->success(__('The cart has been saved.'));
                    return $this->redirect(['controller'=>'Product', 'action' => 'cracker']);
                }
            }
        }else{
            if(isset($_COOKIE["productInfo"])){
                $productInfo=$_COOKIE["productInfo"];
                $productInfo = json_decode($productInfo);

                $find = false;
                foreach($productInfo as $index=>$item){

                    if($item->productId == $Product_ID){
                        $count = $item->count+1;
                        $productInfo[$index]->count = $count;
                        $find = true;
                    }
                }
                if(!$find){
                    $product = array(
                        'productId' => $Product_ID,
                        'count' => 1
                    );
                    array_push($productInfo, $product);
                }
                setcookie("productInfo", json_encode($productInfo), time()+3600,'/');

                // $_COOKIE["productInfo"] = $productInfo;
               //$item = array_search($Product_ID, $productInfo);
               //array_push()
               //debug($item); %5B%7B%22productId%22%3A%223%22%2C%22count%22%3A1%7D%5D
            }else{
                $list=array(
                    array(
                        'productId' => $Product_ID,
                        'count' => 1
                    )
                );
                setcookie("productInfo", json_encode($list), time()+3600,'/');
                //$_COOKIE["productInfo"]=$list;
            }
            return $this->redirect(['controller'=>'Product', 'action' => 'cracker']);
        }



    }
    public function hamperadd($Product_ID=null)
    {
        $User_ID = $this->Auth->user('id');
        if($User_ID){
            $cart = $this->Carts->newEmptyEntity();
            if ($this->request->is('post')) {
                $query = $this->Carts->find("all", [
                    'contain' => [],
                    'conditions' => ['Product_ID' => $Product_ID]
                ]);
                $carts = $query->all();
                if($carts->isempty()){ //no value
                    $data = array(
                        "Product_ID"  => $Product_ID,
                        "count" => 1,
                        "User_ID" => $this->Auth->user('id')
                    );
                    $cart = $this->Carts->patchEntity($cart, $data);
                    if ($this->Carts->save($cart)) {
                        $this->Flash->success(__('The cart has been saved.'));

                        return $this->redirect(['controller'=>'Product', 'action' => 'hamper']);
                    }
                    $this->Flash->error(__('The cart could not be saved. Please, try again.'));
                }else{ // "have value";
                    foreach ($carts as $cart) {
                        $list = $this->Carts->newEmptyEntity();
                        $count = $cart->count;
                        $count++;
                        $item = array(
                            "id" => $cart->id,
                            "Product_ID"  => $Product_ID,
                            "count" => $count,
                            "User_ID" => $this->Auth->user('id')
                        );
                        $order = $this->Carts->patchEntity($list, $item);
                        $id = $cart->id;
                        $order->id = $id;
                        $this->Carts->save($order);
                    }
                    $this->Flash->success(__('The cart has been saved.'));
                    return $this->redirect(['controller'=>'Product', 'action' => 'hamper']);
                }
            }
        }else{
            if(isset($_COOKIE["productInfo"])){
                $productInfo=$_COOKIE["productInfo"];
                $productInfo = json_decode($productInfo);

                $find = false;
                foreach($productInfo as $index=>$item){

                    if($item->productId == $Product_ID){
                        $count = $item->count+1;
                        $productInfo[$index]->count = $count;
                        $find = true;
                    }
                }
                if(!$find){
                    $product = array(
                        'productId' => $Product_ID,
                        'count' => 1
                    );
                    array_push($productInfo, $product);
                }
                setcookie("productInfo", json_encode($productInfo), time()+3600,'/');

                // $_COOKIE["productInfo"] = $productInfo;
               //$item = array_search($Product_ID, $productInfo);
               //array_push()
               //debug($item); %5B%7B%22productId%22%3A%223%22%2C%22count%22%3A1%7D%5D
            }else{
                $list=array(
                    array(
                        'productId' => $Product_ID,
                        'count' => 1
                    )
                );
                setcookie("productInfo", json_encode($list), time()+3600,'/');
                //$_COOKIE["productInfo"]=$list;
            }
            return $this->redirect(['controller'=>'Product', 'action' => 'hamper']);
        }
    }
    public function addflatbread($Product_ID=null)
    {
        $User_ID = $this->Auth->user('id');
        if($User_ID){
            $cart = $this->Carts->newEmptyEntity();
            if ($this->request->is('post')) {
                $query = $this->Carts->find("all", [
                    'contain' => [],
                    'conditions' => ['Product_ID' => $Product_ID]
                ]);
                $carts = $query->all();
                if($carts->isempty()){ //no value
                    $data = array(
                        "Product_ID"  => $Product_ID,
                        "count" => 1,
                        "User_ID" => $this->Auth->user('id')
                    );
                    $cart = $this->Carts->patchEntity($cart, $data);
                    if ($this->Carts->save($cart)) {
                        $this->Flash->success(__('The cart has been saved.'));

                        return $this->redirect(['controller'=>'Product', 'action' => 'flatbread']);
                    }
                    $this->Flash->error(__('The cart could not be saved. Please, try again.'));
                }else{ // "have value";
                    foreach ($carts as $cart) {
                        $list = $this->Carts->newEmptyEntity();
                        $count = $cart->count;
                        $count++;
                        $item = array(
                            "id" => $cart->id,
                            "Product_ID"  => $Product_ID,
                            "count" => $count,
                            "User_ID" => $this->Auth->user('id')
                        );
                        $order = $this->Carts->patchEntity($list, $item);
                        $id = $cart->id;
                        $order->id = $id;
                        $this->Carts->save($order);
                    }
                    $this->Flash->success(__('The cart has been saved.'));
                    return $this->redirect(['controller'=>'Product', 'action' => 'flatbread']);
                }
            }
        }else{
            if(isset($_COOKIE["productInfo"])){
                $productInfo=$_COOKIE["productInfo"];
                $productInfo = json_decode($productInfo);

                $find = false;
                foreach($productInfo as $index=>$item){

                    if($item->productId == $Product_ID){
                        $count = $item->count+1;
                        $productInfo[$index]->count = $count;
                        $find = true;
                    }
                }
                if(!$find){
                    $product = array(
                        'productId' => $Product_ID,
                        'count' => 1
                    );
                    array_push($productInfo, $product);
                }
                setcookie("productInfo", json_encode($productInfo), time()+3600,'/');

                // $_COOKIE["productInfo"] = $productInfo;
               //$item = array_search($Product_ID, $productInfo);
               //array_push()
               //debug($item); %5B%7B%22productId%22%3A%223%22%2C%22count%22%3A1%7D%5D
            }else{
                $list=array(
                    array(
                        'productId' => $Product_ID,
                        'count' => 1
                    )
                );
                setcookie("productInfo", json_encode($list), time()+3600,'/');
                //$_COOKIE["productInfo"]=$list;
            }
            return $this->redirect(['controller'=>'Product', 'action' => 'flatbread']);
        }



    }

    /**
     * Edit method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null, $productId=null)
    {
        $User_ID = $this->Auth->user('id');
        if($User_ID){
            $cart = $this->Carts->get($id, [
                'contain' => [],
            ]);

            if ($this->request->is(['patch', 'post', 'put'])) {
                $cart = $this->Carts->patchEntity($cart, $this->request->getData());
                if ($this->Carts->save($cart)) {
                    $this->Flash->success(__('The cart has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The cart could not be saved. Please, try again.'));
            }
            $this->set(compact('cart'));
        }else{
            if(isset($_COOKIE["productInfo"])){
                $carts=json_decode($_COOKIE["productInfo"]);
                foreach($carts as $cart){
                    if($cart->productId == $productId){
                        $curCart = $cart;
                    }
                }
                if ($this->request->is(['patch', 'post', 'put'])) {
                    $curCart->count = $this->request->getData('count');
                    foreach($carts as $index=>$cart){
                        if($cart->productId == $productId){
                            $carts[$index]->count = $curCart->count;
                        }
                    }
                    setcookie("productInfo", json_encode($carts), time()+3600,'/');
                    return $this->redirect(['action' => 'index']);
                }else{
                    foreach($carts as $cart){
                        if($cart->productId == $productId){
                            $curCart = $cart;
                        }
                    }
                    $item = array(
                        'id' =>  0,
                        'Product_ID' => $curCart->productId,
                        'count' => $curCart->count,
                        'User_ID' => 0,
                    );
                    $cart = $this->Carts->newEmptyEntity();
                    $curCart = $this->Carts->patchEntity($cart, $item);
                    $this->set(array('cart'=>$curCart));
                }
            }
        }

    }

    /**
     * Delete method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $productId=null)
    {
        $User_ID = $this->Auth->user('id');
        if($User_ID){
            $this->request->allowMethod(['post', 'delete']);
            $cart = $this->Carts->get($id);
            if ($this->Carts->delete($cart)) {
                $this->Flash->success(__('The cart has been deleted.'));
            } else {
                $this->Flash->error(__('The cart could not be deleted. Please, try again.'));
            }
        }else{
            if(isset($_COOKIE["productInfo"])){
                $carts=json_decode($_COOKIE["productInfo"]);
                $curCarts = array();
                foreach($carts as $index=>$cart){
                    if($cart->productId != $productId){
                       array_push($curCarts,$cart);
                    }
                }
                setcookie("productInfo", json_encode($curCarts), time()+3600,'/');
            }
        }
        return $this->redirect(['action' => 'index']);

    }
}
