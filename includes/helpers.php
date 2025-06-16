<?php

/**
 * Set an HTML-safe 'value' attribute of a form field from $_POST data.
 *
 * @param string $fieldName The name of the field to display.
 * @return string The HTML entity-encoded output for the form field.
 */
function setValue(string $fieldName, array $info = []): string
{
  // Get HTML-encoded POST data value
  $fieldValue = getEncodedValue($fieldName, $info);

  // Generate HTML output
  return " value='$fieldValue'";
}

/**
 * Get an HTML-safe value of a form field from $_POST data.
 *
 * @param string $fieldName The name of the field to display.
 * @return string The HTML entity-encoded output for the form field.
 */
function getEncodedValue(string $fieldName, array $info = []): string
{

  if (isset($_POST[$fieldName])) {
      $fieldValue = $_POST[$fieldName];
  } elseif (isset($info[$fieldName])) {
      $fieldValue = $info[$fieldName];
  } else {
      $fieldValue = "";
  }

  return htmlspecialchars($fieldValue ?? "", ENT_QUOTES);
}

/**
 * Return the "selected" attribute if the field value is selected.
 *
 * @param string $fieldName The name of the field to display.
 * @param string $fieldValue The value of the field to compare against.
 * @return string The "selected" attribute if the field value matches.
 */
function setSelected(string $fieldName, string $fieldValue, array $info = []): string
{
  $selectedValue = $_POST[$fieldName] ?? $info[$fieldName] ?? "";
  return $selectedValue === $fieldValue ? "selected" : "";
}