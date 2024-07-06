<?php

declare(strict_types=1);

namespace Drupal\custom_entity_sample;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of custom entity sample type entities.
 *
 * @see \Drupal\custom_entity_sample\Entity\CustomEntitySampleType
 */
final class CustomEntitySampleTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No custom entity sample types available. <a href=":link">Add custom entity sample type</a>.',
      [':link' => Url::fromRoute('entity.custom_entity_sample_type.add_form')->toString()],
    );

    return $build;
  }

}
