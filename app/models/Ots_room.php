<?php
class Ots_room
{
	private $db;
	public function __construct()
	{
		$this->db = new Database;
	}

		public function add_room($data)
        {
             $this->db->query('INSERT INTO rooms(room_no, room_type, floor_no, building_no, address) VALUES (:room_no, :room_type, :floor_no, :building_no, :address)');
            // Bind values
            $this->db->bind(':room_no', $data['room_no']);
            $this->db->bind(':room_type', $data['room_type']);
            $this->db->bind(':floor_no', $data['floor_no']);
            $this->db->bind(':building_no', $data['building_no']);
            $this->db->bind(':address', $data['address']);
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
	    public function get_available_rooms()
	    {
	    	$this->db->query('SELECT * FROM rooms');

	    	$row = $this->db->resultSet();
	    	return $row;
	    }
        public function status_cancel_for_room($id)
        {
           
        $this->db->query('UPDATE rooms SET status = :status WHERE id = :id ');
              // Bind values
            $this->db->bind(':id', $id);
            $this->db->bind(':status', '4');
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
        
         public function status_cancel_restore_for_rooms($id)
        {
           
        $this->db->query('UPDATE rooms SET status = :status WHERE id = :id ');
              // Bind values
            $this->db->bind(':id', $id);
            $this->db->bind(':status', '0');
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

         public function get_mem_data($user_id)
    {
        $this->db->query('SELECT * FROM users WHERE mem_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->resultSet();
        return $row;
    }
 public function update_password_db($cpass, $id, $photo)
    {
        $this->db->query('UPDATE users SET mem_pass = :cpass, mem_photo = :photo WHERE mem_id = :id');
        $this->db->bind(':cpass', $cpass);
        $this->db->bind(':id', $id);
        $this->db->bind(':photo', $photo);
        $this->db->execute();
        return true;
    }

    public function getRooms($roomNo)
    {
        $this->db->query("SELECT * FROM rooms WHERE room_no LIKE concat('%', :roomNo, '%')");
        $this->db->bind(':roomNo', $roomNo);
        return $rooms = $this->db->resultSet();
    }

    public function createBedDb($bedID, $roomNo)
    {
        $this->db->query('INSERT INTO beds (bed_number, bed_room) VALUES(:bedID, :roomNo)');
        $this->db->bind(':bedID', $bedID);
        $this->db->bind(':roomNo', $roomNo);
        $this->db->execute();
        return true;
    }

    public function bookRoomDb($roomNumber, $bedId, $fromDate, $toDate)
    {
        $this->db->query('INSERT INTO room_booking (room_number, bed_id, from_date, to_date) VALUES(:roomNumber, :bedId, :fromDate, :toDate)');
        $this->db->bind(':roomNumber', $roomNumber);
        $this->db->bind(':bedId', $bedId);
        $this->db->bind(':fromDate', $fromDate);
        $this->db->bind(':toDate', $toDate);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }

    public function getAllRoomBooking()
    {
        $this->db->query('SELECT * FROM room_booking');
        return $row = $this->db->resultSet();
    }

    public function cancelBooking($id)
    {
        $this->db->query('DELETE FROM room_booking WHERE booking_id = :id');
        $this->db->bind(':id', $id);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }

    public function getTheBeds($id)
    {
        $this->db->query('SELECT * FROM beds WHERE bed_room = :id');
        $this->db->bind(':id', $id);
        return $row = $this->db->resultSet();
    }
    
    public function get_available_beds()
    {
        $this->db->query('SELECT * FROM beds');

        $row = $this->db->resultSet();
        return $row;
    }
	
}
?>