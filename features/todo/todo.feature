Feature: Todo List Project

  @acceptance @end-to-end-api @end-to-end-front
  Scenario: Todo List Creation
    Given I'm connected as "Anael"
    When I create a todo list named "My super todo list"
    Then "My super todo list" should have 0 task

  @acceptance @end-to-end-api @end-to-end-front
  Scenario: Task Addition
    Given I'm connected as "Anael"
    And a todo list named "My Todo List"
    When I add a task named "Do BDD" to the list "My Todo List"
    Then "My Todo List" should have 1 task
