<?php

/**
 * Set an HTML-safe 'value' attribute of a form field from $_POST data.
 *
 * @param string $fieldName The name of the field to display.
 * @return string The HTML entity-encoded output for the form field.
 */
function setValue(string $fieldName): string
{
  // Get HTML-encoded POST data value
  $fieldValue = getEncodedValue($fieldName);

  // Generate HTML output
  return " value='$fieldValue'";
}

/**
 * Get an HTML-safe value of a form field from $_POST data.
 *
 * @param string $fieldName The name of the field to display.
 * @return string The HTML entity-encoded output for the form field.
 */
function getEncodedValue(string $fieldName): string
{
  // Get the value from the POST data
  $fieldValue = $_POST[$fieldName] ?? "";

  // Safely encode the value for HTML output
  $fieldValue = htmlspecialchars($fieldValue);

  // Generate HTML output
  return $fieldValue;
}
