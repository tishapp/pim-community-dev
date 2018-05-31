@javascript
Feature: Edit a channel
  In order to manage existing channels in the catalog
  As an administrator
  I need to be able to edit a channel

  Background:
    Given a "footwear" catalog configuration

  @transform-to-acceptance-back @transform-to-acceptance-front
  Scenario: Successfully edit a channel
    Given I am logged in as "Peter"
    And I am on the "tablet" channel page
    Then I should see the Code field
    And the field Code should be disabled
    When I fill in the following information:
      | English (United States) | My tablet |
    And I press the "Save" button
    Then I should see the text "My tablet"

  @skip-nav @transform-to-acceptance-front
  Scenario: Successfully display a dialog when we quit a page with unsaved changes
    Given I am logged in as "Peter"
    When  I am on the "mobile" channel page
    And I fill in the following information:
      | English (United States) | My mobile |
    And I click on the Akeneo logo
    Then I should see "You will lose changes to the channel if you leave this page." in popup

  @transform-to-acceptance-front
  Scenario: Successfully display a message when there are unsaved changes
    Given I am logged in as "Peter"
    When  I am on the "mobile" channel page
    And I fill in the following information:
      | English (United States) | My mobile |
    Then I should see the text "There are unsaved changes."

  @transform-to-acceptance-back @info split this test, there are 2 use cases
  Scenario: Successfully edit a channel to enable a locale and disable unused locales when deleting a channel
    Given I am logged in as "Peter"
    When  I am on the "tablet" channel page
    And I change the "Locales" to "Breton (France)"
    And I press the "Save" button
    Then I should not see the text "There are unsaved changes."
    And I am on the locales page
    And I filter by "activated" with operator "equals" and value "yes"
    Then the grid should contain 3 elements
    And I should see locales "en_US", "br_FR" and "fr_FR"
    When I am on the "tablet" channel page
    And I press the secondary action "Delete"
    And I confirm the deletion
    And I am on the locales page
    Then the grid should contain 2 element
    And I should see locale "en_US" and "fr_FR"

  @transform-to-acceptance-front
  Scenario: Successfully display the translation of the unit of metrics
    Given I am logged in as "Julien"
    And  I am on the "tablet" channel page
    And I fill in the following information:
      | Volume   | Décilitre |
      | Longueur | Kilomètre |
      | Poids    | Once      |

  @transform-to-acceptance-back @jira https://akeneo.atlassian.net/browse/PIM-6025
  Scenario: Successfully replace a channel locale by another one when there is only one channel
    Given I am logged in as "Peter"
    And I am on the channels page
    And I click on the "Delete" action of the row which contains "Tablet"
    And I confirm the deletion
    And I am on the "mobile" channel page
    When I change the "Locales" to "German (Germany)"
    And I press the "Save" button
    Then I should not see the text "There are unsaved changes."
    When I am on the locales page
    And I filter by "activated" with operator "equals" and value "yes"
    Then the grid should contain 1 elements
    And I should see locales "de_DE"

  @transform-to-acceptance-back @transform-to-acceptance-front
  Scenario: Successfully display validation message when the required currencies field is empty
    Given I am logged in as "Peter"
    And I am on the "tablet" channel page
    And I fill in the following information:
      | Currencies |  |
    And I press the "Save" button
    Then I should see the text "This collection should contain 1 element or more."
    And I fill in the following information:
      | Currencies | USD |
    And I press the "Save" button
    And I should not see the text "There are unsaved changes."
    Then I should not see the text "This collection should contain 1 element or more."

  @transform-to-acceptance-back
  Scenario: Successfully display validation message when the required locales field is empty
    Given I am logged in as "Peter"
    And I am on the "tablet" channel page
    And I fill in the following information:
      | Locales |  |
    And I press the "Save" button
    Then I should see the text "This collection should contain 1 element or more."

  @transform-to-acceptance-back @transform-to-acceptance-front
  Scenario: Successfully updates a channel conversion units
    Given I am logged in as "Peter"
    And I am on the "tablet" channel page
    And I fill in the following information:
      | Volume | Liter      |
      | Length | Millimeter |
    When I press the "Save" button
    Then I should not see the text "There are unsaved changes."
    And the field Volume should contain "Liter"
    And the field Length should contain "Millimeter"
    And the field Weight should contain "Do not convert"
    When I fill in the following information:
      | Volume | Do not convert |
      | Length | Millimeter     |
      | Weight | Gram           |
    And I press the "Save" button
    Then I should not see the text "There are unsaved changes."
    And the field Weight should contain "Gram"
    And the field Length should contain "Millimeter"
    And the field Volume should contain "Do not convert"

  @dev-needed @transform-to-acceptance-back @transform-to-acceptance-front @info We are not sure about its doabilty
  Scenario: Successfully updates a channel and its history
    Given I am logged in as "Peter"
    And I am on the "tablet" channel page
    And I fill in the following information:
      | Volume | Liter      |
      | Length | Millimeter |
    And I press the "Save" button
    And I should not see the text "There are unsaved changes."
    When I visit the "History" tab
    Then there should be 2 updates
