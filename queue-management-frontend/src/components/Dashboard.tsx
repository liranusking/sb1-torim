import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Line } from 'react-chartjs-2';

interface AppointmentStats {
  date: string;
  total_appointments: number;
  completed_appointments: number;
}

interface RevenueStats {
  date: string;
  total_revenue: number;
}

const Dashboard: React.FC = () => {
  const [appointmentStats, setAppointmentStats] = useState<AppointmentStats[]>([]);
  const [revenueStats, setRevenueStats] = useState<RevenueStats[]>([]);

  useEffect(() => {
    const fetchStats = async () => {
      try {
        const appointmentResponse = await axios.get('http://localhost:8000/api/reports/appointment-stats');
        setAppointmentStats(appointmentResponse.data);

        const revenueResponse = await axios.get('http://localhost:8000/api/reports/revenue-stats');
        setRevenueStats(revenueResponse.data);
      } catch (error) {
        console.error('Error fetching stats:', error);
      }
    };

    fetchStats();
  }, []);

  const appointmentChartData = {
    labels: appointmentStats.map(stat => stat.date),
    datasets: [
      {
        label: 'Total Appointments',
        data: appointmentStats.map(stat => stat.total_appointments),
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
      },
      {
        label: 'Completed Appointments',
        data: appointmentStats.map(stat => stat.completed_appointments),
        borderColor: 'rgb(255, 99, 132)',
        tension: 0.1
      }
    ]
  };

  const revenueChartData = {
    labels: revenueStats.map(stat => stat.date),
    datasets: [
      {
        label: 'Total Revenue',
        data: revenueStats.map(stat => stat.total_revenue),
        borderColor: 'rgb(54, 162, 235)',
        tension: 0.1
      }
    ]
  };

  return (
    <div>
      <h2>Dashboard</h2>
      <div>
        <h3>Appointment Statistics</h3>
        <Line data={appointmentChartData} />
      </div>
      <div>
        <h3>Revenue Statistics</h3>
        <Line data={revenueChartData} />
      </div>
    </div>
  );
};

export default Dashboard;