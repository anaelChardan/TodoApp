import React from 'react';

export type TaskDataProps = {
  name: string,
  identifier: string
}

const Task = ({name, identifier}: TaskDataProps) => {
  return <li>{name}</li>
};

export default Task;
