import React from 'react';

export type TaskDataProps = {
  name: string,
  identifier: string
}

const Task = ({name, identifier}: TaskDataProps) => {
  return <li className="task">{name}</li>
};

export default Task;
