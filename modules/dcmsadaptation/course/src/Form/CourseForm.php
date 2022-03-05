<?php
    namespace Drupal\course\Form;
    use Drupal\Core\Form\FormBase;
    use Drupal\Core\Form\FormStateInterface;
    use Drupal\Code\Database\Database;
    use Drupal\Core\Messenger;

    class CourseForm extends FormBase{

        /**
         * {@inheritdoc}
         */

        public function getFormId(){

            return 'create_course';
        }


        /**
         * {@inheritdoc}
         */

        
        public function buildForm(array $form, FormStateInterface $form_state ){
/*
            $genderOptions = array(
                '0'=>'Select Gender',
                'Male'=>'Male',
                'Female'=>'Female'
            );
*/
            $form['Libele']= array(
                '#type'=>'textfield',
                '#title'=>t('Libele'),
                '#defautl_value'=>'',
                '#required'=>true,
                '#attributes'=>array(
                    'placeholder'=>'Libelle'
                )
            );
/*
            $form['Titrecourse']= array(
                '#type'=>'textfield',
                '#title'=>t('Titrecourse'),
                '#defautl_value'=>'',
                '#attributes'=>array(
                    'placeholder'=>'Titre'
                )
            );
*/
            $form['Description']= array(
                '#type'=>'textarea',
                '#title'=>t('Description'),
                '#defautl_value'=>'',
                '#attributes'=>array(
                    'placeholder'=>'description'
                )
            );
/*
            $form['gender']= array(
                '#type'=>'select',
                '#value'=>'Gender',
                '#options'=>$genderOptions
            );
*/
            $form['save']= array(
                '#type'=>'submit',
                '#value'=>'Save course',
                '#button_type'=>'primary'
            );

            return $form;
        }


        /**
         * {@inheritdoc}
         */
         /*
        public function validateForm(array &$form , FormStateInterface $form_state ){
            $Libele = $form_state->getValue('Libele');

            if(trim($Libele) == ''){
                $form_state->setErrorByName('Libele', $this->t('Libele field is required'));
            }
        }
*/

        /**
         * {@inheritdoc}
         */

        public function submitForm(array &$form, FormStateInterface $form_state){

            $postData = $form_state->getValues();
/*
            echo "<pre>";
            print_r($postData);
            echo "</pre>";
            exit;
*/     

            /**
             * Remove the unwanted keys form postdata
             */
            unset($postData['save'], $postData['form_build_id'], $postData['form_token'], $postData['form_id'],$postData['op']);
            
            $query = \Drupal::database();
            $query ->insert('courses')->fields($postData)->execute();

            $messenger = \Drupal::messenger();

            $messenger->addMessage('Course data save successfuly !','status');
            
        }
    
    }
