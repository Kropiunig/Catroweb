@api @upload @tag
Feature: Upload a program with tag

  Background:
    Given there are extensions:
      | id | internal_title |
      | 1  | arduino        |
      | 2  | drone          |
      | 3  | mindstorms     |
      | 4  | phiro          |
      | 5  | embroidery     |

  Scenario: uploading a embroidery project should add the extension to the program
    Given I have an embroidery project
    And I use the "english" app, API version 1
    When I upload this generated program, API version 1
    Then the embroidery program should have the "embroidery" extension

  Scenario: uploading a normal project should not add an extension to the project
    Given I have a program
    And I use the "english" app, API version 1
    When I upload this generated program, API version 1
    Then the project should have no extension

