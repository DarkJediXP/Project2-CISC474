<?php
    class Documents_Controller extends Page{

      public function action_index(){
          $this->view->title = 'Document List';
          $this->active_tab = 'signatures';
      }
 
      public function action_add(){
          $this->view->title = 'Add New Document';
          $this->active_tab = 'signatures';
          $this->view->signatures_view = Misc::find_file('views', 'add_document');
      }
	   
      public function action_save(){
        $doc = ORM::factory('document');
        $doc->user_id = $this->myUser->user_id;
        $doc->title = $this->request->post('title');
        $doc->content = $this->request->post('content');
        $doc->signature = $this->request->post('glyph');
        $doc->date_added = date('Y-m-d H:i:s');
        $doc->save();

        Logger_Model::Log($this->myUser->name . " added a new document " . $doc->title);

        $this->success_message = "Document Saved!";
        $this->action_index();
      }
      
      
      public function action_saveEdit(){
      	  $id = $this->request->post('doc_id');
      	  $doc = ORM::factory('document',$id);
	  	 // echo $doc->title;
	  	  $doc->content = $this->request->post('editedContent');
	      $doc->save();
	      $this->success_message = "Your changes have been saved!";   
	      $this->action_index();
	      
      }
      // instead of $users we use $doc
       public function action_documents_service(){
            header('Content-Type: application/json');
           
            $sort_field = 'date_added';
            $sort_dir = 'desc';
            if(isset($_GET['sort'])){
                $sort_field = $_GET['sort'][0]['field'];
                if($sort_field == 'name') $sort_field = 'users.name';
                $sort_dir = $_GET['sort'][0]['dir'];
            }
            $res = DB::query('select')->table('documents')
                ->fields('document_id', 'user_id', 'title', 'content', 'signature', 'date_added', 'approved')
            
                ->offset($_GET['skip'])
                ->limit($_GET['take'])
                ->order_by($sort_field, $sort_dir)
                ->execute();
		
			
            $count = DB::query('count')->table('documents')->execute();
            echo json_encode(array('PageSize' => $count, 'Result' => $res->as_array()));
            //echo $count;
            exit;
        }

    }
?>