<?php

namespace Drupal\as_league\Form\Organization;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AddForm extends FormBase {

  public function getFormId() {
    return 'as_league_org_add_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['org_id'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Org ID'),
        '#required' => TRUE,
        '#maxlength' => 4,
        '#default_value' =>'',
      ];

    $form['org_full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Org Full Name'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['org_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Org Name'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['webiste'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Website'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['org_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Org Color'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['street'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Street'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['state'] = [
      '#type' => 'textfield',
      '#title' => $this->t('State'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['zip_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Zip Code'),
      '#required' => TRUE,
      '#default_value' => '',
    ];
    

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    $back_url = Url::fromRoute('as_league.orgs.list');
    $back_link = Link::fromTextAndUrl($this->t('Back'), $back_url)->toRenderable();
    $back_link['#attributes'] = ['class' => ['button']];

    $form['actions']['back'] =  [
      '#markup' => '',
      'back_button' => $back_link
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $connection = Database::getConnection();

    $fields = [
      'org_id'        => $form_state->getValue('org_id'),
      'org_full_name' => $form_state->getValue('org_full_name'),
      'org_name'      => $form_state->getValue('org_name'),
    ];

    $connection->insert('as_league_orgs')->fields($fields)->execute();

    Cache::invalidateTags(['as_league_cache_tag']);

    $response = new RedirectResponse('/as_league/orgs/list');
    $response->send();
  }
}
