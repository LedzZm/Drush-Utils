<?php

namespace Drupal\fix\Commands;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drush\Commands\DrushCommands;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * TODO: add docs if needed.
 *
 */
class EntityBulkSaveCommands extends DrushCommands {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private EntityTypeManagerInterface $entityTypeManager;

  /**
   * Constructs a new EntityBulkSaveCommands object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Entity type service.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   *
   * @command TODO::entity_bulk_save
   * @aliases ebs
   * @options arr An option that takes multiple values.
   * TODO: allow multiple types.
   * @options TODO: Check or remove.
   * @usage TODO: add example.
   * TODO: find a better name.
   *  - Make Generic
   *  - Add options for loadByProperties
   *  - add a simple function
   *  - maybe use factory dp
   *  - dump something if in cli
   *  - keep stuff for logging at the end.
   *  - Error Handling.
   *  - Add ProgressBar.
   *  - Add admin UI.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException|\Drupal\Core\Entity\EntityStorageException
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    $group_storage = $this->entityTypeManager->getStorage('group');
    $schools = $group_storage->loadByProperties(['type' => 'group_1']);
    if (empty($schools)) {
      return;
    }

    $progressBar = new ProgressBar($output, count($schools));
    $progressBar->start();
    foreach ($schools as $school) {
      $school->save();
      $progressBar->advance();
    }
    $progressBar->finish();
  }

}

