Feature:
  In Order to allow the user to Search through the vast array of articles on our site As a user
  I want to have a search on every page

  Scenario: Search for an article on the home page
    Given I am on "/"
    When I fill in "searchInput" with "abc"
    And I press "Search"
    Then I should see "Broadcasting"