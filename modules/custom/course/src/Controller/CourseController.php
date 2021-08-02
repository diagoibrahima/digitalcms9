<?php
    namespace Drupal\course\Controller;
    use Drupal\Core\Controller\ControllerBase;
    use Drupal\Code\Database\Database;

    class CourseController extends ControllerBase{
        public function createCourse(){
            $form = \Drupal::formBuilder()->getForm('Drupal\course\Form\CourseForm');
            // $renderForm = \Drupal::service('renderer')->render($form);

            return [
                '#theme'=>'course',
                '#items'=>$form,
                '#title'=>'Add Course'
            ];
        }

        public function getCourseList(){
            $query = \Drupal::database();
            $result = $query->select('courses','c')
                    ->fields('c', ['Libele','Description'])
                    ->execute()->fetchAll(\PDO::FETCH_OBJ);

            $data = [];
            $count = 1;

            foreach($result as $row){
                $data[] = [
                    'Serial_no'=> $count.".",
                    'Libele'=> $row->Libele,
                    'Description'=> $row->Description,
                    'Edit'=>'Edit',
                    'Delete'=>'Delete'
                ];
                $count++;
                
            }

            $header = array('S_no','Libele','Description','Edit', 'Delete');

            $build['table'] = [
                '#type'=>'table',
                '#header'=>$header,
                '#rows'=>$data
            ];

          
             return [
                '#theme'=>'courseListe',
                '#items2'=>$build,
                '#title'=>'List de cours'
            ];
        }


    }