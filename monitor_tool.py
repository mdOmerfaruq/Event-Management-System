import psutil
import time
import matplotlib.pyplot as plt

# Constants for power calculation
CPU_TDP = 65  # Thermal Design Power of the CPU in watts
RAM_POWER_PER_GB = 3  # Power usage per GB of RAM in watts

def get_process_metrics_by_pid_name(pid, process_name):
    """Retrieve CPU, memory, and power usage for a specific PID and process name."""
    try:
        proc = psutil.Process(pid)
        if process_name.lower() in proc.name().lower():
            cpu = proc.cpu_percent(interval=0.5) / psutil.cpu_count()  # CPU usage as a percentage
            memory = proc.memory_info().rss / (1024 ** 2)  # Memory usage in MB
            power = CPU_TDP * (cpu / 100) + RAM_POWER_PER_GB * (memory / 1024)  # Power in watts
            return cpu, memory, power
        else:
            print(f"PID {pid} does not belong to a process named '{process_name}'.")
            return None, None, None
    except (psutil.NoSuchProcess, psutil.AccessDenied, psutil.ZombieProcess):
        print(f"Process with PID {pid} is no longer active.")
        return None, None, None

def get_network_metrics():
    """Retrieve total network usage."""
    net_io = psutil.net_io_counters()
    network_usage = (net_io.bytes_sent + net_io.bytes_recv) / (1024 ** 2)  # Convert to MB
    return network_usage

def plot_usage_by_pid_name(pid, process_name):
    """Monitor and plot resource usage for a specific PID and process name."""
    plt.ion()
    fig, ax = plt.subplots(4, 1, figsize=(5, 6), gridspec_kw={"hspace": 0.8})  # Increased hspace for better spacing

    timestamps = []
    cpu_usage = []
    memory_usage = []
    power_usage = []
    network_usage = []

    try:
        while True:
            # Gather data
            timestamp = time.strftime("%H:%M:%S")
            cpu, memory, power = get_process_metrics_by_pid_name(pid, process_name)
            net_usage = get_network_metrics()

            if cpu is None:  # If the process no longer exists or doesn't match the name
                break

            # Append data
            timestamps.append(timestamp)
            cpu_usage.append(cpu)
            memory_usage.append(memory)
            power_usage.append(power)
            network_usage.append(net_usage)

            # Keep last 10 records (10-second window)
            if len(timestamps) > 10:
                timestamps.pop(0)
                cpu_usage.pop(0)
                memory_usage.pop(0)
                power_usage.pop(0)
                network_usage.pop(0)

            # Clear plots
            for subplot in ax:
                subplot.clear()

            # Plot CPU usage
            ax[0].plot(timestamps, cpu_usage, label="CPU Usage (%)", color="blue", marker="o", markersize=3)
            ax[0].set_ylabel("CPU (%)", fontsize=4)
            ax[0].legend(fontsize=6, loc="upper left")
            ax[0].tick_params(axis='x', rotation=45, labelsize=4)
            ax[0].set_title(f"(a) CPU Usage: {cpu:.2f}%", pad=4)  # Dynamic title update

            # Plot Memory usage
            ax[1].plot(timestamps, memory_usage, label="Memory Usage (MB)", color="green", marker="o", markersize=3)
            ax[1].set_ylabel("Memory (MB)", fontsize=4)
            ax[1].legend(fontsize=6, loc="upper left")
            ax[1].tick_params(axis='x', rotation=45, labelsize=4)
            ax[1].set_title(f"(b) Memory Usage: {memory:.2f} MB", pad=4)  # Dynamic title update

            # Plot Power usage
            ax[2].plot(timestamps, power_usage, label="Power Usage (W)", color="red", marker="o", markersize=3)
            ax[2].set_ylabel("Power (W)", fontsize=4)
            ax[2].legend(fontsize=6, loc="upper left")
            ax[2].tick_params(axis='x', rotation=45, labelsize=4)
            ax[2].set_title(f"(c) Power Usage: {power:.3f} W", pad=4)  # Dynamic title update

            # Plot Network usage
            ax[3].plot(timestamps, network_usage, label="Network Usage (MB)", color="orange", marker="o", markersize=3)
            ax[3].set_ylabel("Network (MB)", fontsize=4)
            ax[3].legend(fontsize=6, loc="upper left")
            ax[3].tick_params(axis='x', rotation=45, labelsize=4)
            ax[3].set_title(f"(d) Network Usage: {net_usage:.2f} MB", pad=4)  # Dynamic title update

            # Print real-time stats
            print(f"Time: {timestamp} | CPU: {cpu:.2f}% | Memory: {memory:.2f} MB | Power: {power:.2f} W | Network: {net_usage:.2f} MB")

             # Automatically adjust subplot spacing
            plt.pause(1)

    except KeyboardInterrupt:
        print("Monitoring stopped.")
        plt.close()

if __name__ == "__main__":
    pid = input("Enter the PID of the process to monitor: ").strip()
    process_name = input("Enter the process name to verify: ").strip()
    if pid.isdigit() and process_name:
        plot_usage_by_pid_name(int(pid), process_name)
    else:
        print("Invalid input. Please enter a numeric PID and a process name.")
