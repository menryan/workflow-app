import { Task } from '@/types';
import { router } from '@inertiajs/react';

interface Props {
  task: Task;
}

export default function TaskRow({ task }: Props) {
  const completeTask = () => {
    router.patch(`/tasks/${task.id}/status`, {
      status: 'completed',
    });
  };

  return (
    <div className="flex justify-between">
      <span>{task.title}</span>

      {task.status !== 'completed' && (
        <button onClick={completeTask}>
          Mark as Completed
        </button>
      )}
    </div>
  );
}
