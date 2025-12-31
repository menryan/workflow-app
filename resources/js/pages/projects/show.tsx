import TaskRow from '@/components/task-row';
import { Project } from '@/types';

interface Props {
  project: Project;
}

export default function Show({ project }: Props) {
  return (
    <div className="max-w-2xl mx-auto p-6">
      <h1 className="text-xl font-semibold mb-4">
        {project.name}
      </h1>

      <ul className="space-y-2">
        {project.tasks.map(task => (
          <TaskRow key={task.id} task={task} />
        ))}
      </ul>
    </div>
  );
}
