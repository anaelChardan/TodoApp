import React, {useEffect, useState} from 'react';
import {useFormik} from "formik";
import Task, {TaskDataProps} from "./Task";
import {getJson, postJson} from "./fetch/fetch-result";
import {isOk} from "./fetch/result";

export type TodoListProps = {
  name: string,
  identifier: string
}

export type TodoListDetails = {
  identifier: string,
  name: string,
  task_count: number,
  tasks: TaskDataProps[]
}

const TodoList = ({name, identifier}: TodoListProps) => {
  const [tasks, setTasks] = useState([]);
  const [count, setTaskCount] = useState(0);

  const getDetails = (identifier: string) => {
    getJson<TodoListDetails, never>(`/todo-list/${identifier}`).then(result => {
      if (isOk(result)) {
        setTasks(result.value.tasks);
        setTaskCount(result.value.task_count);
      }
    });
  };

  const formik = useFormik({
    initialValues: {
      name: ''
    },
    onSubmit: values => {
      postJson<{task_identifier: string}, never>(`/todo-list/${identifier}/task`, {name: values.name}).then(result => {
        if (isOk(result)) {
          getDetails(identifier)
        }
      });
      formik.resetForm();
    }
  });

  useEffect(() => getDetails(identifier), []);

  return <>
      <h2>TodoList: {name} ({count})</h2>

      <form onSubmit={formik.handleSubmit}>
        <label htmlFor="name">Task Name : </label>
        <input id="name" name="name" type="text" onChange={formik.handleChange} value={formik.values.name}/>
        <button type="submit">Add a task!</button>
      </form>

      <ul>
        {tasks.map(e => <Task key={e.identifier} name={e.name} identifier={e.name}/>)}
      </ul>

    </>
};

export default TodoList;
