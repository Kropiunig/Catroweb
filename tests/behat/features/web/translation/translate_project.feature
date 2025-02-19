@web @project_page
Feature: Project title, description and credits should be translatable via a button

  Background:
    Given there are users:
      | id | name     |
      | 1  | Catrobat |
      | 2  | Alex     |
    And there are projects:
      | id | name     | owned by | description   | credit   |
      | 1  | project1 | Catrobat |               |          |
      | 2  | project2 | Catrobat | mydescription |          |
      | 3  | project3 | Catrobat |               | mycredit |
      | 4  | project4 | Catrobat | mydescription | mycredit |

  Scenario: Translate button should translate only title when description and credits not available
    Given I am on "/app/project/1"
    And I wait for the page to be loaded
    When I click "#program-translation-button"
    And I wait for AJAX to finish
    Then the element "#remove-program-translation-button" should be visible
    And the element "#name-translation" should be visible
    And the "#name-translation" element should contain "translated project1"
    And the element "#description" should be visible
    And the "#description" element should contain "No description available."
    And the element "#credits" should be visible
    And the "#credits" element should contain "No notes and credits available."
    When I click "#remove-program-translation-button"
    Then the element "#program-translation-button" should be visible
    And the element "#name" should be visible
    And the "#name" element should contain "project1"

  Scenario: Translate button should translate title and description when available
    Given I am on "/app/project/2"
    And I wait for the page to be loaded
    When I click "#program-translation-button"
    And I wait for AJAX to finish
    Then the element "#remove-program-translation-button" should be visible
    And the element "#name-translation" should be visible
    And the "#name-translation" element should contain "translated project2"
    And the element "#description-translation" should be visible
    And the "#description-translation" element should contain "translated mydescription"
    When I click "#remove-program-translation-button"
    Then the element "#program-translation-button" should be visible
    And the element "#name" should be visible
    And the element "#description" should be visible

  Scenario: Translate button should translate title and credit when available
    Given I am on "/app/project/3"
    And I wait for the page to be loaded
    When I click "#program-translation-button"
    And I wait for AJAX to finish
    Then the element "#remove-program-translation-button" should be visible
    And the element "#name-translation" should be visible
    And the "#name-translation" element should contain "translated project3"
    And the element "#credits-translation" should be visible
    And the "#credits-translation" element should contain "translated mycredit"
    When I click "#remove-program-translation-button"
    Then the element "#program-translation-button" should be visible
    And the element "#name" should be visible
    And the element "#credits" should be visible

  Scenario: Translate button should translate title, description, and credit when available
    Given I am on "/app/project/4"
    And I wait for the page to be loaded
    When I click "#program-translation-button"
    And I wait for AJAX to finish
    Then the element "#remove-program-translation-button" should be visible
    And the element "#name-translation" should be visible
    And the "#name-translation" element should contain "translated project4"
    And the element "#description-translation" should be visible
    And the "#description-translation" element should contain "translated mydescription"
    And the element "#credits-translation" should be visible
    And the "#credits-translation" element should contain "translated mycredit"
    When I click "#remove-program-translation-button"
    Then the element "#program-translation-button" should be visible
    And the element "#name" should be visible
    And the element "#description" should be visible
    And the element "#credits" should be visible

  Scenario: Translate button should translate title, description, and credit only once
    Given I am on "/app/project/1"
    And I wait for the page to be loaded
    When I click "#program-translation-button"
    And I wait for AJAX to finish
    Then the element "#remove-program-translation-button" should be visible
    And the element "#name-translation" should be visible
    When I click "#remove-program-translation-button"
    Then the element "#program-translation-button" should be visible
    And the element "#name" should be visible
    When I click "#program-translation-button"
    Then the element "#remove-program-translation-button" should be visible
    And the element "#name-translation" should be visible

  Scenario: Translation should show translated by line
    Given I am on "/app/project/4"
    And I wait for the page to be loaded
    When I click "#program-translation-button"
    And I wait for AJAX to finish
    Then the element "#credits-translation-wrapper" should be visible
    And the "#program-translation-before-languages" element should contain "Translated by iTranslate from"
    And the "#program-translation-first-language" element should contain "English"
    And the "#program-translation-between-languages" element should contain "to"
    And the "#program-translation-second-language" element should contain "English"
    And the "#program-translation-after-languages" element should contain ""

  Scenario: Translation button should not be visible for projects the user created
    Given I log in as "Catrobat"
    And I am on "/app/project/1"
    And I wait for the page to be loaded
    Then the element "#program-translation-button" should not exist

  Scenario: Translation button should be visible for projects the user did not create
    Given I log in as "Alex"
    And I am on "/app/project/1"
    And I wait for the page to be loaded
    Then the element "#program-translation-button" should be visible

  Scenario: Translation button should be visible for projects when not logged in
    Given I am on "/app/project/1"
    And I wait for the page to be loaded
    Then the element "#program-translation-button" should be visible
