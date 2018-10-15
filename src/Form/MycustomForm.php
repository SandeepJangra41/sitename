<?php

 /**
     * @file
     * Contains \Drupal\mycustom\Form\MycustomForm.
     */

    namespace Drupal\mycustom\Form;

    use Drupal\Core\Form\FormBase;
    use Drupal\Core\Form\FormStateInterface;
    use Drupal\Component\Utility\UrlHelper;

    /**
     * Contribute form.
     */
    class MycustomForm extends FormBase {
      /**
       * {@inheritdoc}
       */
      public function getFormId() {
	return 'mycustom';
      }

      /**
       * {@inheritdoc}
       */
      public function buildForm(array $form, FormStateInterface $form_state) {
      	$form['website_name'] = array(
          '#type' => 'select',
          '#title' => t('Select  Website'),
          '#options' => array(
              'new_drupal' => 'New Drupal 8',
          ),
        );
        $form['website_setting'] = array(
          '#type' => 'select',
          '#title' => t('Select  Config'),
          '#options' => array(
              'site_name' => 'Site Name',
          ),
        );
        $form['sites_name'] = array(
          '#type' => 'textfield',
          '#title' => t('Site Name'),
          '#required' => TRUE,
        );
        $form['submit'] = array(
          '#type' => 'submit',
          '#value' => t('Submit')
        );
        return $form;
      }

      /**
       * {@inheritdoc}
       */
      public function validateForm(array &$form, FormStateInterface $form_state) {
        
   //     echo '<pre>'; print_r($form_state->getValue('sites_name')); die;
        if (empty($form_state->getValue('sites_name'))) {
          $form_state->setErrorByName('sites_name', $this->t('Site name field can not be empty.'));
        }      
        
      }

      /**
       * {@inheritdoc}
       */
      public function submitForm(array &$form, FormStateInterface $form_state) {
         $client = \Drupal::httpClient();
            $request = $client->post('http://drupal8.local/custom-api/post.json', [
              'json' => [
                'sites_name'=> $form_state->getValue('sites_name')
              ]
            ]);

           $response = json_decode($request->getBody());
           drupal_set_message($this->t('Site name has been changed successfully'));
        //     echo '<pre>'; print_r($response); die;
      }
    }