import TaskRow from '@/components/task-row';
import { PageProps } from '@/types';
import { Project } from '@/types';

interface Props extends PageProps {
  project: Project;
}

export default function Show({ project }: Props) {
  return (
    <div>
      <h1>{project.name}</h1>

      {project.tasks.map(task => (
        <TaskRow key={task.id} task={task} />
      ))}
    </div>
  );
}
