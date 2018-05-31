echo "ReloadIng......"
cmd = $(pidof reload_timer)

kill -USR1 "$cmd"
echo "Reload."