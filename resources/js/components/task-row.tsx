import { Task } from '@/types';
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

  return (
    <li className="flex items-center justify-between border p-3 rounded">
      <span>{task.title}</span>

      {task.status !== 'completed' && (
        <button
          onClick={markCompleted}
          className="text-sm text-green-600 hover:underline"
        >
          Mark as completed
        </button>
      )}

      {task.status === 'completed' && (
        <span className="text-sm text-gray-500">
          Completed
        </span>
      )}
    </li>
  );
}
