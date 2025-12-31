import { Task, TaskStatus } from '@/types';
import { router } from '@inertiajs/react';

interface Props {
  task: Task;
}

export default function TaskRow({ task }: Props) {
  const markCompleted = () => {
    router.patch(
      `/tasks/${task.id}/status`,
      { status: 'completed' },
        { 
            preserveScroll: true,
            onError: errors => {
                alert(errors.status ?? 'You are not allowed to perform this action.');
            },
        },
    );
  };

  const markInProgress = () => {
    router.patch(
      `/tasks/${task.id}/status`,
      { status: 'in_progress' },
        { 
            preserveScroll: true,
            onError: errors => {
                alert(errors.status ?? 'You are not allowed to perform this action.');
            },
        },
    );
  };

  return (
    <li className="grid grid-cols-3 border p-3 rounded">
      <span>{task.title}</span>
      <span>{task.status}</span>
      
      {task.status !== 'draft' && task.status !== 'completed' && (
        <button
          onClick={markCompleted}
          className="text-sm text-green-600 hover:underline"
        >
          Mark as 'completed'
        </button>
      )}

      {task.status !== 'in_progress' && task.status !== 'completed' && (
        <button
          onClick={markInProgress}
          className="text-sm text-green-600 hover:underline"
        >
          Mark as 'in progress'
        </button>
      )}
    </li>
  );
}
