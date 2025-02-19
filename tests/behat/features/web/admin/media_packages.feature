@admin
Feature: Media Packages
  It should be possible to list all media packages

  Background:
    Given there are admins:
      | name   | password | token      | email                | id |
      | Admoon | 123456   | eeeeeeeeee | admin@pocketcode.org | 0  |
    And there are users:
      | name     | password | token      | email               | id |
      | Superman | 123456   | cccccccccc | dev1@pocketcode.org | 1  |
      | Gregor   | 123456   | dddddddddd | dev2@pocketcode.org | 2  |
    And there are media packages:
      | name    | name_url |
      | Looks   | looks    |
      | Sounds  | sounds   |
      | Objects | objects  |
    And there are flavors:
      | id | name       |
      | 1  | pocketcode |

  Scenario: List media packages sorted by Name
    Given I log in as "Admoon" with the password "123456"
    And I am on "/admin/media_package/list"
    And I wait for the page to be loaded
    Then I should see the media packages table:
      | name    | name_url |
      | Looks   | looks    |
      | Sounds  | sounds   |
      | Objects | objects  |

  Scenario: Delete media package
    Given I log in as "Admoon" with the password "123456"
    And I am on "/admin/media_package/list"
    And I wait for the page to be loaded
    Then I should see the media packages table:
      | name    | name_url |
      | Looks   | looks    |
      | Sounds  | sounds   |
      | Objects | objects  |
    Then I am on "/admin/media_package/1/delete"
    And I wait for the page to be loaded
    Then I click on the first ".btn-danger" button
    And I wait for the page to be loaded
    Then I should see the media packages table:
      | name    | name_url |
      | Sounds  | sounds   |
      | Objects | objects  |

  Scenario: Adding a media package
    Given I log in as "Admoon" with the password "123456"
    And I am on "/admin/media_package/list"
    And I wait for the page to be loaded
    Then I should see the media packages table:
      | name    | name_url |
      | Looks   | looks    |
      | Sounds  | sounds   |
      | Objects | objects  |
    And I click on the "new" link
    And I wait for the page to be loaded
    Then I should be on "/admin/media_package/create"
    Then I write "Backgrounds" in textarea with label "Name"
    Then I write "backgrounds" in textarea with label "Url"
    Then I click ".btn-success"
    And I wait for the page to be loaded
    And I am on "/admin/media_package/list"
    Then I should see the media packages table:
      | name        | name_url    |
      | Looks       | looks       |
      | Sounds      | sounds      |
      | Objects     | objects     |
      | Backgrounds | backgrounds |

  Scenario: Editing a media category
    Given I log in as "Admoon" with the password "123456"
    And I am on "/admin/media_package/list"
    And I wait for the page to be loaded
    Then I should see the media packages table:
      | name    | name_url |
      | Looks   | looks    |
      | Sounds  | sounds   |
      | Objects | objects  |
    Then I am on "/admin/media_package/3/edit"
    And I wait for the page to be loaded
    Then I write "Backgrounds" in textarea with label "Name"
    Then I write "backgrounds" in textarea with label "Url"
    Then I click on the button named "btn_update_and_list"
    And I am on "/admin/media_package/list"
    And I wait for the page to be loaded
    Then I should see the media packages table:
      | name        | name_url    |
      | Looks       | looks       |
      | Sounds      | sounds      |
      | Backgrounds | backgrounds |
