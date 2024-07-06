<?php

declare(strict_types=1);

namespace Drupal\custom_entity_sample\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\custom_entity_sample\CustomEntitySampleInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the custom entity sample entity class.
 *
 * @ContentEntityType(
 *   id = "custom_entity_sample",
 *   label = @Translation("Custom Entity Sample"),
 *   label_collection = @Translation("Custom Entity Samples"),
 *   label_singular = @Translation("custom entity sample"),
 *   label_plural = @Translation("custom entity samples"),
 *   label_count = @PluralTranslation(
 *     singular = "@count custom entity samples",
 *     plural = "@count custom entity samples",
 *   ),
 *   bundle_label = @Translation("Custom Entity Sample type"),
 *   handlers = {
 *     "list_builder" = "Drupal\custom_entity_sample\CustomEntitySampleListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\custom_entity_sample\CustomEntitySampleAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\custom_entity_sample\Form\CustomEntitySampleForm",
 *       "edit" = "Drupal\custom_entity_sample\Form\CustomEntitySampleForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "custom_entity_sample",
 *   admin_permission = "administer custom_entity_sample types",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/custom-entity-sample",
 *     "add-form" = "/custom-entity-sample/add/{custom_entity_sample_type}",
 *     "add-page" = "/custom-entity-sample/add",
 *     "canonical" = "/custom-entity-sample/{custom_entity_sample}",
 *     "edit-form" = "/custom-entity-sample/{custom_entity_sample}/edit",
 *     "delete-form" = "/custom-entity-sample/{custom_entity_sample}/delete",
 *     "delete-multiple-form" = "/admin/content/custom-entity-sample/delete-multiple",
 *   },
 *   bundle_entity_type = "custom_entity_sample_type",
 *   field_ui_base_route = "entity.custom_entity_sample_type.edit_form",
 * )
 */
final class CustomEntitySample extends ContentEntityBase implements CustomEntitySampleInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage): void {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Label'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Enabled')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => 'enabled-disabled',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(self::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the custom entity sample was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the custom entity sample was last edited.'));

    return $fields;
  }

}