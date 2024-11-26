<?php

namespace App\Services;

use App\Exceptions\InvalidNumbericException;
use App\Exceptions\ObjectEmptyException;
use App\Http\Requests\RoomRequest;
use App\Models\Cinema;
use App\Models\Room;
use App\Repositories\Room\RoomRepositoryInterface;

class RoomService
{
    protected $roomRepositoryInterface;

    public function __construct(RoomRepositoryInterface $roomRepositoryInterface)
    {
        $this->roomRepositoryInterface = $roomRepositoryInterface;
    }
    
    public function getAll($size, $isEnabled)
    {
        if (!is_numeric($size) || $size < 0) {
            throw new InvalidNumbericException("size phải là một số nguyên lớn hơn 0");
        }

        if (empty($isEnabled)) {
            return $this->roomRepositoryInterface->getAll($size);
        }
        return $this->roomRepositoryInterface->getAllIsEnabled($size, $isEnabled);
    }


    public function getById($id)
    {
        $room = $this->roomRepositoryInterface->getById($id);

        if (empty($room)) {
            throw new ObjectEmptyException('Không có phong nào có id là ' . $id);
        }
        return $room;
    }

    public function create(RoomRequest $request)
    {
        $cinemaId = $request->get('cinema_id');
        $cinema = Cinema::find($cinemaId);

        if(empty($cinema)){
            throw new ObjectEmptyException('Rap khong ton tai');
        }
        return $this->roomRepositoryInterface->createOrUpdate($request, null);
    }

    public function update(RoomRequest $request, $id)
    {
        $room = Room::find($id);

        if(empty($room)){
            throw new ObjectEmptyException('Phong khong ton tai');
        }

        $cinemaId = $request->get('cinema_id');
        $cinema = Cinema::find($cinemaId);

        if(empty($cinema)){
            throw new ObjectEmptyException('Rap khong ton tai');
        }

        return $this->roomRepositoryInterface->createOrUpdate($request, $id);
    }

    public function isEnabled($id)
    {
        $room = Room::find($id);

        if (empty($room)) {
            throw new ObjectEmptyException('Không có phong nào có id là ' . $id);
        }

        $this->roomRepositoryInterface->isEnabled($room);

        return $room;
    }
}