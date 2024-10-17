import React, { useState, useEffect } from 'react';
import axios from 'axios';

interface WaitingListItem {
  id: number;
  user: {
    name: string;
  };
  service: {
    name: string;
  };
  requested_date: string;
  status: string;
}

const WaitingList: React.FC = () => {
  const [waitingList, setWaitingList] = useState<WaitingListItem[]>([]);

  useEffect(() => {
    const fetchWaitingList = async () => {
      try {
        const response = await axios.get('http://localhost:8000/api/waiting-list');
        setWaitingList(response.data);
      } catch (error) {
        console.error('Error fetching waiting list:', error);
      }
    };

    fetchWaitingList();
  }, []);

  return (
    <div>
      <h2>Waiting List</h2>
      <ul>
        {waitingList.map((item) => (
          <li key={item.id}>
            {item.user.name} - {item.service.name} - {new Date(item.requested_date).toLocaleDateString()} - {item.status}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default WaitingList;