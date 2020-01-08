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

  useEffect(() => {
    getDetails(identifier);

    const eventSource = new EventSource('http://localhost:8050/.well-known/mercure?topic=' + encodeURIComponent(`http://test.com/todo-list/${identifier}`));
    eventSource.onmessage = event => {
      getDetails(identifier);
    };
  }, []);

  return <div className="todo-list">
    <h2>TodoList: <span className="todo-list-name">{name}</span> <span className="todo-list-count">({count})</span></h2>

      <form onSubmit={formik.handleSubmit}>
        <label htmlFor="name">Task Name : </label>
        <input id="task-name" name="name" type="text" onChange={formik.handleChange} value={formik.values.name}/>
        <button type="submit">Add a task!</button>
      </form>

      <ul className="tasks-list">
        {tasks.map(e => <Task key={e.identifier} name={e.name} identifier={e.name}/>)}
      </ul>

    </div>
};

export default TodoList;
