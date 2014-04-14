Feature: ls
    In order to see the directory
    As a Unix user
    I need to be able to list the current directory's contents


    @javascript
    Scenario: searching for a word that exists
        Given I am on "/"
        When I fill in "search" with "velociraptor"
        And I press "searchButton"
        And I should see "an enlarged sickle-shaped claw"