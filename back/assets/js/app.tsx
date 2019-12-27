import TodoList, {TodoListProps} from "./TodoList";

require('../css/app.css');

import React, {useEffect, useState} from 'react';
import ReactDom from 'react-dom';
import {useFormik} from "formik";
import {fetchResult, postJson} from "./fetch/fetch-result";
import {isOk} from "./fetch/result";

const App = () => {
  const [todoLists, setTodoLists] = useState([]);

  const formik = useFormik({
    initialValues: {
      name: ''
    },
    onSubmit: values => {
      postJson<{todo_list_identifier: string}, never>(`/todo-list`, {name: values.name}).then(result => {
        if (isOk(result)) {
          setTodoLists([...todoLists, {name: values.name, identifier: result.value.todo_list_identifier}]);
        }
      });
      formik.resetForm();
    }
  });

  useEffect(() => {
    fetchResult<TodoListProps[], never>('/todo-list').then(result => {
      if (isOk(result)) {
        if (result)
        setTodoLists(result.value);
      }
    })
  }, []);

  return (
    <>
      <h1> My Beautiful Todo Lists! </h1>

      <form onSubmit={formik.handleSubmit}>
        <label htmlFor="name">Todo List name : </label>
        <input
          id="name"
          name="name"
          type="text"
          onChange={formik.handleChange}
          value={formik.values.name}
        />
        <button type="submit">Add!</button>
      </form>

      {todoLists.map(t => <TodoList key={t.identifier} name={t.name} identifier={t.identifier}/>)}
    </>
  );
};

ReactDom.render(<App />, document.getElementById('root'));


