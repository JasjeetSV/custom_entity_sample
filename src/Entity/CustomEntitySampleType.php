<?php

declare(strict_types=1);

namespace Drupal\custom_entity_sample\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Custom Entity Sample type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "custom_entity_sample_type",
 *   label = @Translation("Custom Entity Sample type"),
 *   label_collection = @Translation("Custom Entity Sample types"),
 *   label_singular = @Translation("custom entity sample type"),
 *   label_plural = @Translation("custom entity samples types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count custom entity samples type",
 *     plural = "@count custom entity samples types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\custom_entity_sample\Form\CustomEntitySampleTypeForm",
 *       "edit" = "Drupal\custom_entity_sample\Form\CustomEntitySampleTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\custom_entity_sample\CustomEntitySampleTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer custom_entity_sample types",
 *   bundle_of = "custom_entity_sample",
 *   config_prefix = "custom_entity_sample_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/custom_entity_sample_types/add",
 *     "edit-form" = "/admin/structure/custom_entity_sample_types/manage/{custom_entity_sample_type}",
 *     "delete-form" = "/admin/structure/custom_entity_sample_types/manage/{custom_entity_sample_type}/delete",
 *     "collection" = "/admin/structure/custom_entity_sample_types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   },
 * )
 */
final class CustomEntitySampleType extends ConfigEntityBundleBase {

  /**
   * The machine name of this custom entity sample type.
   */
  protected string $id;

  /**
   * The human-readable name of the custom entity sample type.
   */
  protected string $label;

}
