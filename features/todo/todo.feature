Feature: Todo List Project

  @acceptance
  Scenario: Todo List Creation
    Given I'm connected as "Anael"
    When I create a todo list named "My super todo list"
    Then "My super todo list" should have 1 task
