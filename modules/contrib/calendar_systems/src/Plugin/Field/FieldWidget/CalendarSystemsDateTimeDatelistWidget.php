<?php

namespace Drupal\calendar_systems\Plugin\Field\FieldWidget;

use Drupal\calendar_systems\CalendarSystems\CalendarSystemsDrupalDateTime;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\Annotation\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\datetime\Plugin\Field\FieldWidget\DateTimeDatelistWidget;

/**
 * Replaces core's widget with a localizable one.
 *
 * @FieldWidget(
 *   id = "datetime_datelist",
 *   label = @Translation("CalendarSystems select list"),
 *   field_types = {
 *     "datetime"
 *   }
 * )
 */
class CalendarSystemsDateTimeDatelistWidget extends DateTimeDatelistWidget {

  /**
   * {@inheritDoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $cal = _calendar_systems_factory();
    if (!$cal) {
      return $element;
    }

    if ($items[$delta] && $items[$delta]->date) {
      $date = $items[$delta]->date;
      $date = CalendarSystemsDrupalDateTime::convert($date);
      $element['value']['#default_value'] = $date;
    }

    return $element;
  }

}
